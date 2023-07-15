<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{
    public function index(Mentor $mentor)
    {
        if (Cache::has('mentor')) {
            $response = Cache::get('mentor');
        } else {
            $response = $mentor->all();
            Cache::put('mentor', $response, 3600);
        }

        $data = [
            'message' => "Show all mentor",
            'data' => $response
        ];

        return ApiResponse::success($data, 200);
    }

    public function show(Mentor $mentor)
    {
        $data = [
            'message' => "Show mentor with id $mentor->id",
            'data' => $mentor
        ];

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        $validate = Validator::make($request->all(), [
            'name' => 'string|required',
            'study_track' => 'string|required',
            'scholar_history' => 'string|required',
            'profile_picture' => 'required|file'
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

            $image = $request->file('profile_picture');
            $data = [
                'file' => $image,
                'file_name' => "$mentor->id." . $image->extension(),
                'file_path' => 'profile_picture_mentor'
            ];

            $url = FileController::manage($data);

            $mentor->image = $url;
            $mentor->save();

            Cache::forget('mentor');
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
        if (!Gate::allows('isAdmin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        $validate = Validator::make($request->all(), [
            'name' => 'string|required',
            'study_track' => 'string|required',
            'scholar_history' => 'string|required',
            'profile_picture' => 'sometimes|file'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $image = $request->file('profile_picture');

        if (!empty($request->profile_picture)) {
            $data = [
                'file' => $image,
                'file_name' => $mentor->id . "." . $image->extension(),
                'file_path' => 'profile_picture_mentor',
                'delete_file' => substr($mentor->image, 8)
            ];

            $url = FileController::manage($data);
        }

        try {
            $mentor->name = $request->name;
            $mentor->study_track = $request->study_track;
            $mentor->scholar_history = $request->scholar_history;
            $mentor->image = $url ?? $mentor->image;
            $mentor->save();

            Cache::forget('mentor');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Successfully updated mentor',
            'data' => $mentor
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Mentor $mentor)
    {
        if (!Gate::allows('isAdmin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        try {
            $mentor->delete();
            Cache::forget('mentor');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Sucessfully deleted mentor";

        return ApiResponse::success($data, 200);
    }

    public function showNew()
    {
        $response = Mentor::orderByDesc('created_at')->take(9)->get();

        $data = [
            'message' => "show 9 newest mentor",
            'data' => $response
        ];

        return ApiResponse::success($data, 200);
    }
}
