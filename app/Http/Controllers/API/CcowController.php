<?php

namespace App\Http\Controllers\API;

use App\Models\Ccow;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CcowController extends Controller
{
    public function fetchAll(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $search = $request->input('search');
            $id = $request->input('id');

            $query = Ccow::query()->with('budget');

            //get ccow by ID
            if ($id) {
                $ccow = $query->find($id);


                if ($ccow) {
                    return ResponseFormatter::success($ccow, 'data found');
                }

                return ResponseFormatter::error('data not found', 404);
            } else {
                $query = $query;
            }


            if ($search) {
                $query->when($search, function ($query, $search) {
                    return $query->where('ccow_name', 'like', "%$search%");
                });
            }


            return ResponseFormatter::success(
                $query->orderBy('ccow_id', 'desc')->paginate($limit),
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
                'ccow_name' => 'required',
                'ccow_code' => 'required',
            ], [
                'ccow_name.required' => 'Nama CCOW harus diisi',
                'ccow_code.required' => 'Kode CCOW harus diisi',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors(),
                ], 400);
            }

            $data = $request->all();
            $ccow = Ccow::create($data);

            return ResponseFormatter::success($ccow, 'data success');


        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ccow_name' => 'required',
                'ccow_code' => 'required',
            ], [
                'ccow_name.required' => 'Nama CCOW harus diisi',
                'ccow_code.required' => 'Kode CCOW harus diisi',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors(),
                ], 400);
            }

            $data = $request->all();
            $ccow = Ccow::find($id);
            $ccow->update($data);

            return ResponseFormatter::success($ccow, 'data success');

        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $ccow = Ccow::find($id);

            if (!$ccow) {
                return ResponseFormatter::error('data not found', 404);
            }

            $ccow->delete();

            return ResponseFormatter::success($ccow, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $ccow = Ccow::onlyTrashed()->where('ccow_id', $id)->first();

            if (!$ccow) {
                return ResponseFormatter::error('data not found', 404);
            }

            $ccow->restore();

            return ResponseFormatter::success($ccow, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function select2Ccow()
    {
        try {
            $ccow = Ccow::select('ccow_id', 'ccow_name')->get();

            return ResponseFormatter::success($ccow, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

}
