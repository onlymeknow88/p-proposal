<?php

namespace App\Http\Controllers\API;

use App\Models\Amount;
use App\Models\FormNop;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class FormNOPController extends Controller
{
    public function fetchAll(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $search = $request->input('search');
            $id = $request->input('id');
            $prop_id = $request->input('prop_id');

            $query = FormNop::query()->with('getAmount', 'proposals');

            //get form NOP by ID
            if ($id) {
                $formNop = $query->where('nop_id', $id)->first();


                if ($formNop) {
                    return ResponseFormatter::success($formNop, 'data found');
                }

                return ResponseFormatter::error('data not found', 404);
            } else {
                $query = $query;
            }

            if ($prop_id) {
                $formNop = $query->where('prop_id', $prop_id)->first();
                if ($formNop) {
                    return ResponseFormatter::success($formNop, 'data found');
                }

                return ResponseFormatter::error('data not found', 404);
            }


            if ($search) {
                $query->when($search, function ($query, $search) {
                    return $query->where('nop_name', 'like', "%$search%");
                });
            }

            return ResponseFormatter::success(
                $query->orderBy('nop_id', 'desc')->paginate($limit),
                'fetch success'
            );
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'nop_name' => 'required|string|max:255',
                    'purpay_id' => 'required',
                    'amount_id' => 'required',
                    'due_date' => 'required',
                    'acc_name'=> 'required|string|max:255',
                    'account_no' => 'required|string|max:255',
                    'bank_name' => 'required|string|max:255',
                    'email' => 'required|string|max:255',
                    'provider' => 'required',
                    'other_info' => 'required',
                    'desc' => 'required',
                    'explanation' => 'required'
                ],
                [
                    'nop_name.required' => 'Nama tidak boleh kosong',
                    'purpay_id.required' => 'Purpose Payment tidak boleh kosong',
                    'amount_id.required' => 'Budget tidak boleh kosong',
                    'due_date.required' => 'Due Date tidak boleh kosong',
                    'acc_name.required' => 'Account Name tidak boleh kosong',
                    'account_no.required' => 'Account Number tidak boleh kosong',
                    'bank_name.required' => 'Bank Name tidak boleh kosong',
                    'email.required' => 'Email tidak boleh kosong',
                    'provider.required' => 'Provider tidak boleh kosong',
                    'other_info.required' => 'Other Info tidak boleh kosong',
                    'desc.required' => 'Description tidak boleh kosong',
                    'explanation.required' => 'Explanation tidak boleh kosong'

                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }
            $data = $request->except('prop_no', 'amount');

            $data['amount'] = $request->input('amount');

            $formNop = FormNop::create($data);


            return ResponseFormatter::success($formNop, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'nop_name' => 'required|string|max:255',
                    'purpay_id' => 'required',
                    'amount_id' => 'required',
                    'due_date' => 'required',
                    'acc_name'=> 'required|string|max:255',
                    'account_no' => 'required|string|max:255',
                    'bank_name' => 'required|string|max:255',
                    'email' => 'required|string|max:255',
                    'provider' => 'required',
                    'other_info' => 'required',
                    'desc' => 'required',
                    'explanation' => 'required'
                ],
                [
                    'nop_name.required' => 'Nama tidak boleh kosong',
                    'purpay_id.required' => 'Purpose Payment tidak boleh kosong',
                    'amount_id.required' => 'Budget tidak boleh kosong',
                    'due_date.required' => 'Due Date tidak boleh kosong',
                    'acc_name.required' => 'Account Name tidak boleh kosong',
                    'account_no.required' => 'Account Number tidak boleh kosong',
                    'bank_name.required' => 'Bank Name tidak boleh kosong',
                    'email.required' => 'Email tidak boleh kosong',
                    'provider.required' => 'Provider tidak boleh kosong',
                    'other_info.required' => 'Other Info tidak boleh kosong',
                    'desc.required' => 'Description tidak boleh kosong',
                    'explanation.required' => 'Explanation tidak boleh kosong'

                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            $data = $request->except('prop_no', 'amount');

            $formNop = FormNop::find($request->nop_id);

            $formNop->update($data);

            return ResponseFormatter::success($data, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $formNop = FormNop::find($id);

            if ($formNop) {
                $formNop->delete();
                return ResponseFormatter::success($formNop, 'data deleted');
            }

            return ResponseFormatter::error('data not found', 404);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function downloadPDF(Request $request)
    {
        try {
            $isLogin = $request->input('isLogin');
            $role = $request->input('role');

            if ($role == 0 || $isLogin == 0) {
                return ResponseFormatter::error('You are not authorized to access this page', 401);
            } else {
                $checkRole = User::where('role_id', $role)->first();

                if ($isLogin == 1 && $checkRole->role_id == 1) {
                    $id = $request->input('id');

                    $formNop = FormNop::find($id);

                    $pdf = Pdf::loadView('form_noi.form_nop_pdf', ['formNop' => $formNop]);
                    $pdfContent = $pdf->output();

                    // Encode the PDF content to base64
                    $base64Pdf = base64_encode($pdfContent);

                    // You can customize the file name here
                    $filename = 'Form NOI.pdf';

                    return response()->json(['pdf' => $base64Pdf, 'filename' => $filename]);
                    // return $pdf->download();
                } else if ($isLogin == 1 && $checkRole->role_id == 2) {
                    $id = $request->input('id');

                    $formNop = FormNop::find($id);

                    $pdf = Pdf::loadView('form_noi.form_nop_pdf', ['formNop' => $formNop]);

                    // return $pdf->download();
                    $pdfContent = $pdf->output();

                    // Encode the PDF content to base64
                    $base64Pdf = base64_encode($pdfContent);

                    // You can customize the file name here
                    $filename = 'Form NOI.pdf';

                    return response()->json(['pdf' => $base64Pdf, 'filename' => $filename]);
                } else {
                    return ResponseFormatter::error('You are not authorized to access this page', 401);
                }
            }
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
