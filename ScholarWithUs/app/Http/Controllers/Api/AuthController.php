<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => "Register Successed",
            'data' => $user
        ];

        return ApiResponse::success($data, 201);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $credentials = $request->only("email", "password");

        $token = Auth::attempt($credentials);

        if (!$token) {
            return ApiResponse::error("Unauthorized", 401);
        }

        $data = [
            'message' => "Login successed",
            'data' => [
                "token" => $token 
            ]
        ];

        return ApiResponse::success($data, 200);
    }

    public function logout()
    {
        Auth::logout();

        $data = [
            'message' => "Logout successed"
        ];

        return ApiResponse::success($data, 200);
    }
}
