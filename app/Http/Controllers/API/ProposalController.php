<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Budget;
use App\Models\Proposal;
use App\Mail\TestingEmail;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use App\Models\ProposalBudget;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProposalController extends Controller
{


    public function fetch(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $search = $request->input('search');
            $status = $request->input('status');
            $skala = $request->input('skala_prioritas');
            $area = $request->input('area');
            $id = $request->input('id');

            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');



            $query = Proposal::query();

            if ($start_date && $end_date) {
                $query = $query->whereBetween('tgl_pengajuan', [$start_date, $end_date]);
            }


            if ($id) {
                $proposal = $query->with('hasFile')->find($id);


                if ($proposal) {
                    return ResponseFormatter::success($proposal, 'data found');
                }

                return ResponseFormatter::error('data not found', 404);
            } else {
                $query = $query;
            }

            if ($status) {
                $query->where('status', $status);
            }
            if ($skala) {
                $query->where('skala_prioritas', $skala);
            }
            if ($area) {
                $query->where('area_id', $area);
            }

            if ($search) {
                $query->when($search, function ($query, $search) {
                    return $query->where('judul', 'like', "%$search%")
                        ->orWhere('prop_no', 'like', "%$search%");
                });
            }

            return ResponseFormatter::success(
                $query->orderBy('prop_id', 'desc')->paginate($limit),
                'fetch proposal success'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'emp_name' => 'required|string|max:255',
                'judul' => 'required|string|max:255',
                'skala_prioritas' => 'required|string|max:255',
                'area_id' => 'required',
                'pengirim' => 'required|string|max:255',
                'perm_bantuan' => 'required',
                'jenis_bantuan' => 'required',
                'budget_id' => 'required',
                'ass_proposal' => 'required',
            ],
            [
                'emp_name.required' => 'Nama tidak boleh kosong',
                'judul.required' => 'Judul Proposal tidak boleh kosong',
                'skala_prioritas.required' => 'Skala Prioritas tidak boleh kosong',
                'area_id.required' => 'Prea tidak boleh kosong',
                'pengirim.required' => 'Pengirim Proposal tidak boleh kosong',
                'perm_bantuan.required' => 'Deskripsi tidak boleh kosong',
                'jenis_bantuan.required' => 'Jenis Bantuan tidak boleh kosong',
                'budget_id.required' => 'Budget Bantuan tidak boleh kosong',
                'ass_proposal.required' => 'Assesment tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 422);
        }

        $data = $request->except('status', 'jumlah_bantuan', 'upload_file', 'user_id', 'checklist_dokumen');
        $data['status'] = '1';

        $currentYear = date('Y');

        $countRecord = Proposal::whereYear('created_at', $currentYear)->get()->count();

        $data['prop_no'] = 'PRP-' . $currentYear . '-' . str_pad($countRecord + 1, 4, '0', STR_PAD_LEFT);
        $data['user_id'] = $request->user()->id;

        $data['jumlah_bantuan'] = $request->jumlah_bantuan;
        $data['checklist_dokumen'] = $request->checklist_dokumen;
        $proposal = Proposal::create($data);


        if ($request->has('upload_file')) {
            foreach ($request->file('upload_file') as $file) {

                $filenameWithExt = $file->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Find or create the UploadFile record
                $uploadFile = UploadFile::firstOrNew(['name' => $filename]);

                // Set or update the proposal_id
                $uploadFile->prop_id = $proposal->id;
                $uploadFile->name = $filename . '-' . $proposal->prop_no;

                // Save the UploadFile record
                $uploadFile->save();
            }
        }

        //approval email data
        // $mailData = [
        //     'data' => $proposal,
        //     'nama_approval' => 'Bustanul Muhadisin',
        //     'approval_level' => 'Dept Head',
        //     'sts_approval' => 'Waiting for Approval',
        //     'tgl_approval' => '....'
        // ];

        // //get email approval from employee is_section_head
        // $send_email_to = 'fadjri.wivindi@adaro.com';

        // $no_reg = $proposal['no_reg'];

        // if ($proposal) {
        //     // Inliner::view('email_approval.notif_approval_request');
        //     // Mail::to("fadjri.w@gmail.com")->send(new TestingEmail($proposal));
        //     Mail::send('email_approval.notif_approval_request', $mailData, function ($message) use ($send_email_to, $no_reg) {
        //         $message->to($send_email_to)
        //             ->subject('PROPOSAL #' . $no_reg);
        //     });
        // }

        return ResponseFormatter::success($proposal, 'data created');
    }

    public function update(Request $request, $id)
    {
        $proposal = Proposal::find($id);

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'emp_name' => 'required|string|max:255',
        //         'judul' => 'required|string|max:255',
        //         'skala_prioritas' => 'required|string|max:255',
        //         'area_id' => 'required',
        //         'pengirim' => 'required|string|max:255',
        //         'perm_bantuan' => 'required',
        //         'jenis_bantuan' => 'required',
        //         'budget_id' => 'required',
        //         'ass_proposal' => 'required',
        //     ],
        //     [
        //         'emp_name.required' => 'Nama tidak boleh kosong',
        //         'judul.required' => 'Judul Proposal tidak boleh kosong',
        //         'skala_prioritas.required' => 'Skala Prioritas tidak boleh kosong',
        //         'area_id.required' => 'Prea tidak boleh kosong',
        //         'pengirim.required' => 'Pengirim Proposal tidak boleh kosong',
        //         'perm_bantuan.required' => 'Deskripsi tidak boleh kosong',
        //         'jenis_bantuan.required' => 'Jenis Bantuan tidak boleh kosong',
        //         'budget_id.required' => 'Budget Bantuan tidak boleh kosong',
        //         'ass_proposal.required' => 'Assesment tidak boleh kosong',
        //     ]
        // );

        // if ($validator->fails()) {
        //     return response()->json([
        //         'error' => true,
        //         'message' => 'Validation error',
        //         'data' => $validator->errors()
        //     ], 422);
        // }

        $data = $request->except('status', 'jumlah_bantuan', 'upload_file', 'user_id', 'checklist_dokumen');
        $data['status'] = '1';
        $data['jumlah_bantuan'] = $request->jumlah_bantuan;
        $data['user_id'] = $request->user()->id;

        $data['checklist_dokumen'] = $request->checklist_dokumen;

        $proposal->update($data);


        if ($request->has('upload_file')) {
            foreach ($request->file('upload_file') as $file) {

                $filenameWithExt = $file->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Find or create the UploadFile record
                $uploadFile = UploadFile::firstOrNew(['name' => $filename]);

                // Set or update the proposal_id
                $uploadFile->prop_id = $proposal->prop_id;
                $uploadFile->name = $filename . '-' . $proposal->prop_no;

                // Save the UploadFile record
                $uploadFile->save();
            }
        } else {
            // Get all UploadFile records with null prop_id
            $filesToDelete = UploadFile::whereNull('prop_id')->get();

            // Delete associated files in storage and database
            foreach ($filesToDelete as $fileToDelete) {
                // Delete file from storage
                Storage::delete('public/' . $fileToDelete->name);

                // Delete the UploadFile record from the database
                $fileToDelete->delete();
            }
        }
        // $proposal= $request->all();

        $user = User::where('is_dept_head', 1)->first();

        $mailData = [
            'data' => $proposal,
            'nama_approval' => $user->name,
            'approval_level' => 'Department Head',
            'sts_approval' => 'Waiting for Approval',
            'tgl_approval' => '....'
        ];

        //get email approval from employee department head
        $appr_email_deptHead = $user->email;

        $no_reg = $proposal['prop_no'];

        // if($proposal)
        // {
        //     // Mail::to("fadjri.w@gmail.com")->send(new TestingEmail($proposal));
        //     Mail::send('email_approval.notif_approval_request', $mailData, function ($message) use ($appr_email_deptHead, $no_reg) {
        //         $message->to($appr_email_deptHead)
        //             ->subject('PROPOSAL #' . $no_reg);
        //     });
        // }

        return ResponseFormatter::success($proposal, 'data updated');
    }

    public function destroy($id)
    {
        try {
            $proposal = Proposal::find($id);
            $uploadFile = UploadFile::where('prop_id', $id)->get();

            if ($proposal) {
                $proposal->delete();
                foreach ($uploadFile as $file) {
                    Storage::disk('public')->delete($file->file_path);
                    $file->delete();
                }
                return ResponseFormatter::success($proposal, 'data deleted');
            }

            return ResponseFormatter::error('data not found', 404);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function returnPrp(Request $request, $id)
    {
        $proposal = Proposal::find($id); {
            $proposal->update([
                'status' => '4',
                'note' => $request->note,
                'sts_app_sh' => '5',
                'app_sh' => $request->user()->id,
                // 'user_id' => $request->user()->id,
            ]);

            //user create proposal
            // $user = User::find($proposal->user_id);

            // $mailData = [
            //     'data' => $proposal,
            //     'nama_approval' => 'Bustanul Muhadisin',
            //     'approval_level' => 'Department Head',
            //     'sts_approval' => 'Return',
            //     'tgl_approval' => $proposal->updated_at
            // ];

            // //send email notifikasi if approved
            // $send_email_to = $user->email;

            // $no_reg = $proposal['no_reg'];
            // //notifsikasi email
            // // Mail::to("fadjri.w@gmail.com")->send(new TestingEmail($proposal));
            // Mail::send('email_approval.notif_approval_request', $mailData, function ($message) use ($send_email_to, $no_reg) {
            //     $message->to($send_email_to)
            //         ->subject('RETURN PROPOSAL #' . $no_reg);
            // });
        }


        return ResponseFormatter::success($proposal, 'data update note/comment');
    }

    public function approval(Request $request, $id)
    {
        $proposal = Proposal::find($id);

        //approval email data
        if ($proposal) {

            //user create proposal
            // $user = User::where('nik', $proposal->user_id)->first();

            //user employee from homepage get is_department_head, is_division_head
            $userHomepage = DB::connection('mysql_homepage')->table('users')
                ->select('employee.is_department_head', 'employee.is_division_head', 'users.nik')
                ->leftJoin('employee', 'users.emp_id', '=', 'employee.emp_id')
                ->where('users.nik', $request->nik)->first();

            // dd($userHomepage->nik);

            //employee from homepage get is_director by nik Pak TOTOK
            $userDirector = DB::connection('mysql_homepage')->table('employee')
                ->where('nik', '80000438')
                ->first();

            $is_director = [
                'name' => $userDirector->name,
                'email' => $userDirector->email,
                'position' => $userDirector->position,
                'is_director' => 1,
            ];

            if ($request->type == 'approve') {
                if ($userHomepage->is_department_head === 1) {
                    $proposal->update([
                        'status' => '1',
                        'app_dh' => $userHomepage->nik,
                        'sts_app_dh' => '2',
                    ]);

                    //notifikasi email
                    // $mailData = [
                    //     'data' => $proposal,
                    //     'nama_approval' => $userHomepage->name,
                    //     'approval_level' => 'Department Head',
                    //     'sts_approval' => 'Approved'
                    // ];

                    // //send email notifikasi if approved
                    // $send_email_to = $user->email;

                    // $no_reg = $proposal['no_reg'];
                    // //notifsikasi email
                    // Mail::send('email_approval.notif_approval_request', $mailData, function ($message) use ($send_email_to, $no_reg) {
                    //     $message->to($send_email_to)
                    //         ->subject('PROPOSAL #' . $no_reg);
                    // });
                } elseif ($userHomepage->is_division_head === 1) {
                    $proposal->update([
                        'status' => '1',
                        'app_dh2' => $userHomepage->nik,
                        'sts_app_dh2' => '2',
                    ]);

                    //notifikasi email
                    // $mailData = [
                    //     'data' => $proposal,
                    //     'nama_approval' => $userHomepage->name,
                    //     'approval_level' => 'Division Head',
                    //     'sts_approval' => 'Approved'
                    // ];

                    // //send email notifikasi if approved
                    // $send_email_to = $user->email;

                    // $no_reg = $proposal['no_reg'];
                    // //notifsikasi email
                    // Mail::send('email_approval.notif_approval_request', $mailData, function ($message) use ($send_email_to, $no_reg) {
                    //     $message->to($send_email_to)
                    //         ->subject('PROPOSAL #' . $no_reg);
                    // });
                } elseif ($is_director['is_director'] == 1) {
                    $proposal->update([
                        'status' => '3',
                        'app_dr' => $userHomepage->nik,
                        'sts_app_dr' => '2',
                    ]);

                    // $budget = Budget::where('budget_bantuan', $proposal->budget_bantuan)->first();
                    // $sisa_dana = $budget->total_budget - $proposal->jumlah_dana;

                    // $budget->update([
                    //     'budget_sisa' => $sisa_dana,
                    // ]);

                    // $proposalBudget = ProposalBudget::create([
                    //     'proposal_id' => $proposal->id,
                    //     'budget_id' => $budget->id,
                    //     'realisasi_budget' => $proposal->jumlah_dana,
                    // ]);

                    //notifikasi email
                    // $mailData = [
                    //     'data' => $proposal,
                    //     'nama_approval' => $userHomepage->name,
                    //     'approval_level' => 'ER Director',
                    //     'sts_approval' => 'Approved'
                    // ];

                    // //send email notifikasi if approved
                    // $send_email_to = $user->email;

                    // $no_reg = $proposal['no_reg'];
                    // //notifsikasi email
                    // Mail::send('email_approval.notif_approval_request', $mailData, function ($message) use ($send_email_to, $no_reg) {
                    //     $message->to($send_email_to)
                    //         ->subject('PROPOSAL #' . $no_reg);
                    // });
                }
            } elseif ($request->type == 'rejected') {
                if ($userHomepage->is_department_head === 1) {

                    $proposal->update([
                        'status' => '5',
                        'app_dh' => $userHomepage->nik,
                        'sts_app_dh' => '3',
                    ]);

                    // $mailData = [
                    //     'data' => $proposal,
                    //     'nama_rejected' => $userHomepage->name,
                    //     'rejected_level' => 'Department Head',
                    //     'sts_approval' => 'Rejected'
                    // ];

                    // //send email notifikasi if rejected
                    // $send_email_to = $user->email;

                    // $no_reg = $proposal['no_reg'];
                    // //notifsikasi email
                    // Mail::send('email_approval.notif_approval_request', $mailData, function ($message) use ($send_email_to, $no_reg) {
                    //     $message->to($send_email_to)
                    //         ->subject('PROPOSAL #' . $no_reg);
                    // });
                } elseif ($userHomepage->is_division_head === 1) {
                    $proposal->update([
                        'status' => '3',
                        'app_dh2' => $userHomepage->nik,
                        'sts_app_dh2' => '3',
                    ]);

                    // $mailData = [
                    //     'data' => $proposal,
                    //     'nama_rejected' => $userHomepage->name,
                    //     'rejected_level' => 'Division Head',
                    //     'sts_approval' => 'Rejected'
                    // ];

                    // //send email notifikasi if rejected
                    // $send_email_to = $user->email;

                    // $no_reg = $proposal['no_reg'];
                    // //notifsikasi email
                    // Mail::send('email_approval.notif_approval_request', $mailData, function ($message) use ($send_email_to, $no_reg) {
                    //     $message->to($send_email_to)
                    //         ->subject('PROPOSAL #' . $no_reg);
                    // });
                } elseif ($is_director['is_director'] === 1) {
                    $proposal->update([
                        'status' => '3',
                        'app_dr' => $userHomepage->nik,
                        'sts_app_dr' => '3',
                    ]);

                    // $mailData = [
                    //     'data' => $proposal,
                    //     'nama_rejected' => $userHomepage->name,
                    //     'rejected_level' => 'ER Director',
                    //     'sts_approval' => 'Rejected'
                    // ];

                    // //send email notifikasi if rejected
                    // $send_email_to = $user->email;

                    // $no_reg = $proposal['no_reg'];
                    // //notifsikasi email
                    // Mail::send('email_approval.notif_approval_request', $mailData, function ($message) use ($send_email_to, $no_reg) {
                    //     $message->to($send_email_to)
                    //         ->subject('PROPOSAL #' . $no_reg);
                    // });
                }
            }
        }


        return ResponseFormatter::success($proposal, 'data update status approval');
    }

    public function uploadCkeditorProposal(Request $request)
    {
        $file = $request->file('files');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        return response()->json(['url' => asset('storage/' . $filePath)]);
    }

    public function uploadFile(Request $request)
    {
        $allowedFileTypes = ['pdf', 'png', 'jpg', 'jpeg'];
        $uploadedFiles = [];

        try {
            foreach ($request->all() as $key => $file) {
                if ($request->hasFile($key)) {
                    // Validate file type
                    $extension = $file->extension();
                    if (!in_array($extension, $allowedFileTypes)) {
                        return response()->json([
                            'error' => true,
                            'message' => 'Invalid file type. Allowed types are pdf, png, jpg, jpeg',
                            // 'data' => ''
                        ], 422);
                    }

                    $filenameWithExt = $file->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                    Storage::disk('public')->put('private_uploads/proposals/' . $filenameWithExt, file_get_contents($file));

                    $uploadedFile = UploadFile::create([
                        'prop_id' => null,
                        'name' => $filename,
                        'file_path' => 'private_uploads/proposals/' . $filenameWithExt,
                        'file_type' => $extension,
                    ]);

                    $uploadedFiles[] = $uploadedFile;
                }
            }

            return response()->json(['data' => $uploadedFiles, 'message' => 'Files uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing the request'], 500);
        }
    }



    public function deleteFile(Request $request)
    {
        $file = UploadFile::find($request->id);
        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return ResponseFormatter::success($file, 'file deleted');
    }
}
