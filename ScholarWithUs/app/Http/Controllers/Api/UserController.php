<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class UserController extends Controller
{
    public function show()
    {   
        try {
            $user = User::find(Auth::user()->id);

            $data = [
                'message' => "user with id $user->id",
                'data' => $user
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $validate = Validator::make($request->all(), [
            'name' => 'string|required',
            'phone_number' => 'string|required',
            'age' => 'int|required',
            'gender' => 'required|in:male,female',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $user->name = $request->name;
            $user->phone_number = $request->phone_number;
            $user->age = $request->age;
            $user->gender = $request->gender;
            $user->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'User updated',
            'data' => $user
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "User Deleted";

        return ApiResponse::success($data, 200);
    }
}
