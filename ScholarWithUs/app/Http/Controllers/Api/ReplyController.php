<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{
    public function index(Reply $reply)
    {
        try {
            $data = [
                'message' => "Get all reply",
                'data' => $reply->paginate(9)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Reply $reply)
    {
        try {
            $data = [
                'message' => "Reply with id $reply->id",
                'data' => $reply
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'discussion_id' => 'int|required',
            'comment' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $reply = new Reply;
            $reply->discussion_id = $request->discussion_id;
            $reply->comment = $request->comment;
            $reply->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Reply created',
            'data' => $reply
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Reply $reply)
    {
        $validate = Validator::make($request->all(), [
            'discussion_id' => 'int|required',
            'comment' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $reply->discussion_id = $request->discussion_id;
            $reply->comment = $request->comment;
            $reply->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Reply updated',
            'data' => $reply
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Reply $reply)
    {
        try {
            $reply->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data['message'] = "Reply Deleted";

        return ApiResponse::success($data, 200);
    }
}
