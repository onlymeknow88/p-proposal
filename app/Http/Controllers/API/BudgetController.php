<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Budget;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BudgetController extends Controller
{
    public function fetchAll(Request $request)
    {

        try {
            $limit = $request->input('limit', 10);
            $search = $request->input('search');
            $id = $request->input('id');

            $query = Budget::query()->with(['ccow']);

            //get budget by ID
            if ($id) {
                $budget = $query->where('budget_id', $id)->first();


                if ($budget) {
                    return ResponseFormatter::success($budget, 'data found');
                }

                return ResponseFormatter::error('data not found', 404);
            } else {
                $query = $query;
            }


            if ($search) {
                $query->when($search, function ($query, $search) {
                    return $query->where('budget_name', 'like', "%$search%")
                        ->orWhereHas('ccow', function ($query) use ($search) {
                            $query->where('ccow_name', 'like', "%$search%");
                        });
                });
            }

            return ResponseFormatter::success(
                $query->orderBy('budget_id', 'desc')->paginate($limit),
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
                    'budget_name' => 'required|string|max:255',
                ],
                [
                    'budget_name.required' => 'Nama tidak boleh kosong',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            $budget = Budget::create([
                'budget_name' => $request->budget_name,
                'ccow_id' => $request->ccow_id,
            ]);

            return ResponseFormatter::success($budget, 'data success');

        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'budget_name' => 'required|string|max:255',
                ],
                [
                    'budget_name.required' => 'Nama tidak boleh kosong',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            $budget = Budget::find($id);

            if ($budget) {
                $budget->update([
                    'budget_name' => $request->budget_name,
                    'ccow_id' => $request->ccow_id,
                ]);

                return ResponseFormatter::success($budget, 'data success');
            }

            return ResponseFormatter::error('data not found', 404);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $budget = Budget::find($id);

            if (!$budget) {
                return ResponseFormatter::error('data not found', 404);
            }

            $budget->delete();

            return ResponseFormatter::success($budget, 'data success');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $budget = Budget::withTrashed()->find($id);

            if (!$budget) {
                return ResponseFormatter::error('data not found', 404);
            }

            $budget->restore();

            return ResponseFormatter::success($budget, 'data success');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function select2Budget(Request $request)
    {
        try {

            $id = $request->input('id');

            if($id){
                $budget = Budget::select('budget_id', 'budget_name','ccow_id')->where('ccow_id', $id)->get();

                return ResponseFormatter::success($budget, 'data success');
            }

            $budget = Budget::select('budget_id', 'budget_name','ccow_id')->get();

            return ResponseFormatter::success($budget, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
