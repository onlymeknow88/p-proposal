<?php

namespace App\Http\Controllers\API;

use App\Models\GLAccount;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GlAccountController extends Controller
{
    public function fetchAll(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $search = $request->input('search');
            $id = $request->input('id');

            $query = GLAccount::query();

            //get gl acc by ID
            if ($id) {
                $glAcc = $query->find($id);


                if ($glAcc) {
                    return ResponseFormatter::success($glAcc, 'data found');
                }

                return ResponseFormatter::error('data not found', 404);
            } else {
                $query = $query;
            }


            if ($search) {
                $query->when($search, function ($query, $search) {
                    return $query->where('gl_account', 'like', "%$search%")
                        ->orWhereHas('ccow', function ($query) use ($search) {
                            $query->where('cost_center', 'like', "%$search%");
                        });
                });
            }

            return ResponseFormatter::success(
                $query->orderBy('gl_acc_id', 'desc')->paginate($limit),
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
            // dd($data);
            $validator = Validator::make($data, [
                'gl_account' => ['required', 'string', 'max:255'],
                'ccow_id' => ['required', 'integer'],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            $glAcc = GLAccount::create($data);

            return ResponseFormatter::success($glAcc, 'store success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'gl_account' => ['required', 'string', 'max:255'],
                'ccow_id' => ['required', 'integer'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            $glAcc = GLAccount::find($id);

            if($glAcc)
            {
                $glAcc->update($data);

                return ResponseFormatter::success($glAcc, 'update success');
            }
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $glAcc = GLAccount::find($id);

            if (!$glAcc) {
                return ResponseFormatter::error('data not found', 404);
            }

            $glAcc->delete();

            return ResponseFormatter::success($glAcc, 'delete success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $glAcc = GLAccount::withTrashed()->find($id);

            if (!$glAcc) {
                return ResponseFormatter::error('data not found', 404);
            }

            $glAcc->restore();

            return ResponseFormatter::success($glAcc, 'restore success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function select2GlAcc()
    {
        try {
            $glAcc = GLAccount::select('gl_acc_id', 'gl_account','ccow_id')->get();


            return ResponseFormatter::success($glAcc, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
