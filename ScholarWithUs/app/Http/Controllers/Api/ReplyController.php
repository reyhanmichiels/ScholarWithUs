<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReplyResource;
use App\Libraries\ApiResponse;
use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{
    public function index(Discussion $discussion)
    {
        $data = [
            'message' => "Show all replies with discussion id $discussion->id",
            'data' => ReplyResource::collection($discussion->replies)
        ];

        return ApiResponse::success($data, 200);
    }

    public function show(Discussion $discussion, Reply $reply)
    {
        if (!$discussion->replies->find($reply->id)) {
            return ApiResponse::error('Replies not found', 404);
        }

        $data = [
            'message' => "Show reply with id $reply->id",
            'data' => new ReplyResource($reply)
        ];

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

            Cache::forget('discussion');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Successfully created reply',
            'data' => new ReplyResource($reply)
        ];

        return ApiResponse::success($data, 201);
    }

    public function destroy(Discussion $discussion, Reply $reply)
    {
        if (!$discussion->replies->find($reply->id)) {
            return ApiResponse::error('Replies not found', 404);
        }

        try {
            $reply->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Successfully deleted reply";

        return ApiResponse::success($data, 200);
    }
}
