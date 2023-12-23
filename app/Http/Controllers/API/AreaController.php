<?php

namespace App\Http\Controllers\API;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function fetchAll(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $search = $request->input('search');
            $id = $request->input('id');

            $query = Area::query();

            //get area by ID
            if ($id) {
                $area = $query->find($id);


                if ($area) {
                    return ResponseFormatter::success($area, 'data found');
                }

                return ResponseFormatter::error('data not found', 404);
            } else {
                $query = $query;
            }


            if ($search) {
                $query->when($search, function ($query, $search) {
                    return $query->where('area_name', 'like', "%$search%");
                });
            }

            return ResponseFormatter::success(
                $query->orderBy('area_id', 'desc')->paginate($limit),
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
                    'area_name' => 'required|string|max:255',
                ],
                [
                    'area_name.required' => 'area nama tidak boleh kosong',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            $area = Area::create([
                'area_name' => $request->area_name,
            ]);

            return ResponseFormatter::success($area, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $area = Area::find($id);

            if (!$area) {
                return ResponseFormatter::error('data not found', 404);
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'area_name' => 'required|string|max:255',
                ],
                [
                    'area_name.required' => 'area nama tidak boleh kosong',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation error',
                    'data' => $validator->errors()
                ], 422);
            }

            $area->update([
                'area_name' => $request->area_name,
            ]);

            return ResponseFormatter::success($area, 'data updated');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $area = Area::find($id);

            if (!$area) {
                return ResponseFormatter::error('data not found', 404);
            }

            $area->delete();

            return ResponseFormatter::success($area, 'data deleted');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $area = Area::withTrashed()->find($id);

            if (!$area) {
                return ResponseFormatter::error('data not found', 404);
            }

            $area->restore();

            return ResponseFormatter::success($area, 'data restored');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function select2Area()
    {
        try {
            $area = Area::select('area_id', 'area_name')->get();

            return ResponseFormatter::success($area, 'data success');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
