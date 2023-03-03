<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    public function index(Program $program)
    {
        try {
            $data = [
                'message' => "Get all program",
                'data' => $program->all()
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Program $program)
    {
        try {
            $data = [
                'message' => "Program with id $program->id",
                'data' => $program
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'scholarship_id' => 'int|required',
            'name' => 'string|required',
            'description' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $program = new Program;
            $program->scholarship_id = $request->scholarship_id;
            $program->name = $request->name;
            $program->description = $request->description;
            $program->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Program created',
            'data' => $program
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Program $program)
    {
        $validate = Validator::make($request->all(), [
            'scholarship_id' => 'int|required',
            'name' => 'string|required',
            'description' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $program->scholarship_id = $request->scholarship_id;
            $program->name = $request->name;
            $program->description = $request->description;
            $program->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Program updated',
            'data' => $program
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Program $program)
    {
        try {
            $program->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data['message'] = "Program Deleted";

        return ApiResponse::success($data, 200);
    }
}
