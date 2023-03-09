<?php

namespace App\Http\Controllers;

use App\Libraries\ApiResponse;
use App\Models\Mentor;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{
    public function index(Mentor $mentor)
    {
        try {
            $data = [
                'message' => "Get all mentor",
                'data' => $mentor->all()
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Mentor $mentor)
    {   
        
        try {
            $data = [
                'message' => "Mentor with id $mentor->id",
                'data' => $mentor
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'string|required',
            'study_track' => 'string|required',
            'scholar_history' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $mentor = new Mentor;
            $mentor->name = $request->name;
            $mentor->study_track = $request->study_track;
            $mentor->scholar_history = $request->scholar_history;
            $mentor->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Mentor created',
            'data' => $mentor
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Mentor $mentor)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'string|required',
            'study_track' => 'string|required',
            'scholar_history' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $mentor->name = $request->name;
            $mentor->study_track = $request->study_track;
            $mentor->scholar_history = $request->scholar_history;
            $mentor->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Mentor updated',
            'data' => $mentor
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Mentor $mentor)
    {
        try {
            $mentor->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Mentor Deleted";

        return ApiResponse::success($data, 200);
    }

    public function showNew(Mentor $mentor)
    {
        try {
            $response = $mentor->all()->sortByDesc('created_at')->take(9);
            
            $data = [
                'message' => "9 newest mentor",
                'data' => $response
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }
}
