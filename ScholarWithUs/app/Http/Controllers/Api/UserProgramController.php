<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;
use App\Libraries\ApiResponse;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProgramController extends Controller
{
    public function index()
    {
        try {
            $user = User::find(Auth::user()->id);
            $data = [
                'message' => "Get all user program with user id $user->id",
                'data' => ProgramResource::collection($user->programs)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Program $program)
    {
        try {
            $user = User::find(Auth::user()->id);

            $data = [
                'message' => "get program with id $program->id from user with id $user->id",
                'data' => $user->programs->where('id', $program->id)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function attach(Program $program)
    {
        try {
            $user = User::find(Auth::user()->id);

            $test = $user->programs->where('id', $program->id);

            if (! empty($test->toArray())) {
                return ApiResponse::error('user already in that programs', 409);
            }

            $user->programs()->attach($program->id);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => "user attached"
        ];

        return ApiResponse::success($data, 201);
    }

    public function detach(Program $program)
    {
        try {
            $user = User::find(Auth::user()->id);

            $test = $user->programs->where('id', $program->id);

            if (empty($test->toArray())) {
                return ApiResponse::error("user doesn't exist in that programs", 409);
            }

            $user->programs()->detach($program->id);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => "user detached"
        ];

        return ApiResponse::success($data, 200);
    }
}
