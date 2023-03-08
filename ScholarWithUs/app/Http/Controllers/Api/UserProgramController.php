<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;
use App\Libraries\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;

class UserProgramController extends Controller
{
    public function index(User $user)
    {
        try {
            $data = [
                'message' => "Get all user program with user id $user->id",
                'data' => ProgramResource::collection($user->programs)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }
}
