<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\PurposePayment;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PurpayController extends Controller
{
    public function fetchAll(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $search = $request->input('search');
            $id = $request->input('id');

            $query = PurposePayment::query();

            //get purpay by ID
            if ($id) {
                $purpay = $query->find($id);


                if ($purpay) {
                    return ResponseFormatter::success($purpay, 'data found');
                }

                return ResponseFormatter::error('data not found', 404);
            } else {
                $query = $query;
            }


            if ($search) {
                $query->when($search, function ($query, $search) {
                    return $query->where('purpay_name', 'like', "%$search%");
                });
            }



            return ResponseFormatter::success(
                $query->orderBy('purpay_id', 'desc')->paginate($limit),
                'fetch success'
            );

        } catch (\Exception $e) {

            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'purpay_name' => 'required',
            ], [
                'purpay_name.required' => 'Nama purpose payment name harus diisi',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors(),
                ], 400);
            }

            $data = $request->all();
            $purpay = PurposePayment::create($data);

            return ResponseFormatter::success($purpay, 'data success');


        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'purpay_name' => 'required',
            ], [
                'purpay_name.required' => 'Nama purpose payment name harus diisi',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors(),
                ], 400);
            }

            $purpay = PurposePayment::find($id);

            if ($purpay) {
                $purpay->update($request->all());

                return ResponseFormatter::success($purpay, 'data success');
            }

            return ResponseFormatter::error('data not found', 404);

        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $purpay = PurposePayment::find($id);

            if (!$purpay) {
                return ResponseFormatter::error('data not found', 404);
            }

            $purpay->delete();

            return ResponseFormatter::success($purpay, 'data success deleted');

        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $purpay = PurposePayment::withTrashed()->find($id);

            if (!$purpay) {
                return ResponseFormatter::error('data not found', 404);
            }

            $purpay->restore();

            return ResponseFormatter::success($purpay, 'data success restored');

        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function select2Purpay()
    {
        try {
            $purpay = PurposePayment::select('purpay_id', 'purpay_name')->get();

            return ResponseFormatter::success($purpay, 'data success');

        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
