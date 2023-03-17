<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TagDiscussionController;
use App\Http\Resources\DiscussionResource;
use App\Libraries\ApiResponse;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class DiscussionController extends Controller
{
    public function index(Discussion $discussion)
    {
        if (Cache::has('discussion')) {
            $response = Cache::get('discussion');
        } else {
            $response = $discussion->all();
            Cache::put('discussion', $response, 3600);
        }

        $data = [
            'message' => "Show all discussion",
            'data' => DiscussionResource::collection($discussion->all())
        ];

        return ApiResponse::success($data, 200);
    }

    public function show(Discussion $discussion)
    {
        $data = [
            'message' => "Show discussion with id $discussion->id",
            'data' => new DiscussionResource($discussion)
        ];

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'string|required|min:10',
            'comment' => 'string|required|min:20',
            'tag' => 'string|required|min:3'
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

            $tag = explode(", ", $request->tag);
            foreach ($tag as $tag) {
                $id = TagDiscussionController::store($tag);
                $discussion->tagDiscussions()->attach($id);
            }

            Cache::forget('discussion');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Successfully created discussion',
            'data' => new DiscussionResource($discussion)
        ];

        return ApiResponse::success($data, 201);
    }

    public function destroy(Discussion $discussion)
    {
        try {
            $discussion->delete();
            Cache::forget('discussion');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Succesfully deleted discussion";

        return ApiResponse::success($data, 200);
    }

    public function search(Request $request, Discussion $discussion)
    {
        $validate = Validator::make($request->all(), [
            'key' => 'string|required|min:3'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $id = collect();

        foreach ($discussion->all() as $diss) {
            $title = strtolower($diss->title);
            $key = strtolower($request->key);

            if (str_contains($title, $key)) {
                $id->push($diss->id);
                continue;
            }

            foreach ($diss->tagDiscussions as $tag) {
                if ($key == $tag->name) {
                    $id->push($diss->id);
                    continue;
                }
            }
        }

        $data = [
            'message' => 'Show all discussion that matching key',
            'data' => DiscussionResource::collection($discussion->get()->only($id->toArray()))
        ];

        return ApiResponse::success($data, 200);
    }
}
