<?php

namespace App\Http\Controllers\API;

use App\Models\Amount;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AmountController extends Controller
{
    public function fetchAll(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $search = $request->input('search');
            $id = $request->input('id');

            $query = Amount::query()->with(['gl_acc']);

            //get amount by ID
            if ($id) {
                $amount = $query->find($id);


                if ($amount) {
                    return ResponseFormatter::success($amount, 'data found');
                }

                return ResponseFormatter::error('data not found', 404);
            } else {
                $query = $query;
            }


            if ($search) {
                $query->when($search, function ($query, $search) {
                    return $query->where('amount', 'like', "%$search%")
                        ->orWhereHas('glacc', function ($query) use ($search) {
                            return $query->where('gl_account', 'like', "%$search%")
                                ->orWhereHas('ccow', function ($query) use ($search) {
                                    return $query->where('ccow_name', 'like', "%$search%")
                                        ->orWhere('ccow_code', 'like', "%$search%")
                                        ->orWhere('cost_center', 'like', "%$search%");
                                });
                        });
                });
            }

            return ResponseFormatter::success(
                $query->orderBy('amount_id', 'desc')->paginate($limit),
                'fetch success'
            );
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'amount' => ['required', 'numeric'],
                'gl_acc_id' => ['required'],
                'year' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            $amount = Amount::create($data);

            return ResponseFormatter::success($amount, 'data created');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'amount' => ['required', 'numeric'],
                'gl_acc_id' => ['required'],
                'year' => ['required'],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            $amount = Amount::find($id);

            $amount->update($data);

            return ResponseFormatter::success($amount, 'data updated');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $amount = Amount::find($id);

            if (!$amount) {
                return ResponseFormatter::error('data not found', 404);
            }

            $amount->delete();

            return ResponseFormatter::success($amount, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $amount = Amount::withTrashed()->find($id);

            if (!$amount) {
                return ResponseFormatter::error('data not found', 404);
            }

            $amount->restore();

            return ResponseFormatter::success($amount, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function select2Amount(Request $request)
    {
        try {
            $id = $request->input('id');

            if($id)
            {
                $amount = Amount::select('amount_id', 'amount','gl_acc_id', 'year')->where('gl_acc_id',$id)->get();

                return ResponseFormatter::success($amount, 'data success');
            }

            $amount = Amount::select('amount_id', 'amount','gl_acc_id', 'year')->with('gl_acc')->get();

            return ResponseFormatter::success($amount, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
