<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReplyResource;
use App\Libraries\ApiResponse;
use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{
    public function index(Discussion $discussion)
    {
        try {
            $data = [
                'message' => "Get all discussion replies with discussion id $discussion->id",
                'data' => ReplyResource::collection($discussion->replies)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() != 0 ? $e->getCode() : 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Discussion $discussion, Reply $reply)
    {   
        if ($reply->discussion_id != $discussion->id) {
            return ApiResponse::error('not found', 404);
        }

        try {
            $data = [
                'message' => "Reply with id $reply->id",
                'data' => new ReplyResource($reply)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() != 0 ? $e->getCode() : 500);
        }

        $response = $discussion->replies->where('id', $reply->id);
        return ApiResponse::success($data, 200);
    }

    public function store(Request $request, Discussion $discussion)
    {
        $validate = Validator::make($request->all(), [
            'comment' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $reply = new Reply;
            $reply->user_id = Auth::user()->id;
            $reply->discussion_id = $discussion->id;
            $reply->comment = $request->comment;
            $reply->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() != 0 ? $e->getCode() : 500);
        }

        $data = [
            'message' => 'Reply created',
            'data' => new ReplyResource($reply)
        ];

        return ApiResponse::success($data, 201);
    }

    public function destroy(Discussion $discussion, Reply $reply)
    {   
        if ($reply->discussion_id != $discussion->id) {
            return ApiResponse::error('not found', 404);
        }

        try {
            $reply->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() != 0 ? $e->getCode() : 500);
        }

        $data['message'] = "Reply Deleted";

        return ApiResponse::success($data, 200);
    }
}
