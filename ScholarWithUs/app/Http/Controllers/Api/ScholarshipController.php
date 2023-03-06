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
            'name' => 'string|required|unique:scholarships',
            'tag_level_id' => 'int|required', 
            'tag_cost_id' => 'int|required', 
            'scholarship_provider' => "string|required",
            'open_registration' => 'date|required',
            'close_registration' => 'date|required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $scholarship = new Scholarship;
            $scholarship->name = $request->name;
            $scholarship->tag_level_id = $request->tag_level_id;
            $scholarship->tag_cost_id = $request->tag_cost_id;
            $scholarship->scholarship_provider = $request->scholarship_provider;
            $scholarship->open_registration = $request->open_registration;
            $scholarship->close_registration = $request->close_registration;
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
            'name' => 'string|required|unique:scholarships,name,' . $scholarship->id,
            'tag_level_id' => 'int|required', 
            'tag_cost_id' => 'int|required', 
            'scholarship_provider' => "string|required",
            'open_registration' => 'date|required',
            'close_registration' => 'date|required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $scholarship->name = $request->name;
            $scholarship->tag_level_id = $request->tag_level_id;
            $scholarship->tag_cost_id = $request->tag_cost_id;
            $scholarship->scholarship_provider = $request->scholarship_provider;
            $scholarship->open_registration = $request->open_registration;
            $scholarship->close_registration = $request->close_registration;
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

    public function showNew(Scholarship $scholarship)
    {
        try {
            $response = $scholarship->all()->sortBy('open_registration')->take(9);

            $data = [
                'message' => "9 newest scholarship",
                'data' => $response
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }
}
