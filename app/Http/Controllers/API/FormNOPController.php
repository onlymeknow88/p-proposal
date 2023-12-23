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
            // $validator = Validator::make(
            //     $request->all(),
            //     [
            //         'budget_name' => 'required|string|max:255',
            //     ],
            //     [
            //         'budget_name.required' => 'Nama tidak boleh kosong',
            //     ]
            // );

            // if ($validator->fails()) {
            //     return response()->json([
            //         'error' => true,
            //         'message' => 'Validation error',
            //         'data' => $validator->errors()
            //     ], 422);
            // }
            $data = $request->except('prop_no', 'amount', 'amount_id');


            $budget = Amount::where('amount_id', $request->input('amount_id'))->first();

            $sisaBudget = $budget->amount - $request->input('amount');

            $budget->update([
                'amount' => $sisaBudget,
            ]);

            $data['amount'] = $request->input('amount');

            // $formNop = FormNop::create($data);


            return ResponseFormatter::success($data, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            // $validator = Validator::make(
            //     $request->all(),
            //     [
            //         'budget_name' => 'required|string|max:255',
            //     ],
            //     [
            //         'budget_name.required' => 'Nama tidak boleh kosong',
            //     ]
            // );

            // if ($validator->fails()) {
            //     return response()->json([
            //         'error' => true,
            //         'message' => 'Validation error',
            //         'data' => $validator->errors()
            //     ], 422);
            // }
            $data = $request->except('prop_no', 'amount', 'amount_id');

            // $formNop = FormNop::update($data);

            return ResponseFormatter::success($data, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function downloadPDF(Request $request)
    {
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

                return $pdf->download();
            } else if ($isLogin == 1 && $checkRole->role_id == 2) {
                $id = $request->input('id');

                $formNop = FormNop::find($id);

                $pdf = Pdf::loadView('form_noi.form_nop_pdf', ['formNop' => $formNop]);

                return $pdf->download();
            } else {
                return ResponseFormatter::error('You are not authorized to access this page', 401);
            }
        }
    }
}
