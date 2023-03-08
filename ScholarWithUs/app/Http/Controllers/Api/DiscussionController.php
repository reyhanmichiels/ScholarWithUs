<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscussionCollection;
use App\Http\Resources\DiscussionResource;
use App\Libraries\ApiResponse;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DiscussionController extends Controller
{
    public function index(Discussion $discussion)
    {   
        try {
            $data = [
                'message' => "Get all discussion",
                'data' => DiscussionResource::collection($discussion->all())
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() != 0 ? $e->getCode() : 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Discussion $discussion)
    {
        try {
            $data = [
                'message' => "Discussion with id $discussion->id",
                'data' => new DiscussionResource($discussion)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() != 0 ? $e->getCode() : 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'string|required',
            'comment' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $discussion = new Discussion;
            $discussion->user_id = Auth::user()->id;
            $discussion->title = $request->title;
            $discussion->comment = $request->comment;
            $discussion->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() != 0 ? $e->getCode() : 500);
        }

        $data = [
            'message' => 'Discussion created',
            'data' => new DiscussionResource($discussion)
        ];

        return ApiResponse::success($data, 201);
    }

    public function destroy(Discussion $discussion)
    {
        try {
            $discussion->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() != 0 ? $e->getCode() : 500);
        }

        $data['message'] = "Discussion Deleted";

        return ApiResponse::success($data, 200);
    }
}
