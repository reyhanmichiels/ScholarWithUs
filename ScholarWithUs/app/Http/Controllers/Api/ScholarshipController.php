<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScholarshipController extends Controller
{
    public function index(Scholarship $scholarship)
    {
        try {
            $data = [
                'message' => "Get all scholarship",
                'data' => $scholarship->all()
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Scholarship $scholarship)
    {
        try {
            $data = [
                'message' => "Scholarship with id $scholarship->id",
                'data' => $scholarship
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'string|required',
            'description' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $scholarship = new Scholarship;
            $scholarship->name = $request->name;
            $scholarship->description = $request->description;
            $scholarship->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Scholarship created',
            'data' => $scholarship
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'string|required',
            'description' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $scholarship->name = $request->name;
            $scholarship->description = $request->description;
            $scholarship->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Scholarship updated',
            'data' => $scholarship
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Scholarship $scholarship)
    {
        try {
            $scholarship->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data['message'] = "scholarship Deleted";

        return ApiResponse::success($data, 200);
    }
}
