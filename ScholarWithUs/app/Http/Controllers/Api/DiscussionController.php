<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TagDiscussionController;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\DiscussionCollection;
use App\Http\Resources\DiscussionResource;
use App\Libraries\ApiResponse;
use App\Models\Discussion;
use App\Models\TagDiscussion;
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
            'comment' => 'string|required',
            'tag' => 'string|required'
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
                // $tagDiscussion = TagDiscussion::all()->where('name', strtolower($tag))->toArray();

                // if (empty($tagDiscussion)) {
                //     $newTagDiscussion = new TagDiscussion;
                //     $newTagDiscussion->name = strtolower($request->tag);
                //     $newTagDiscussion->save();
                //     $tagDiscussion = $newTagDiscussion;
                // }
                $id = TagDiscussionController::store($tag);
                $discussion->tagDiscussions()->attach($id);
            }
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
            'data' => DiscussionResource::collection($discussion->all()->only($id->toArray()))
        ];

        return ApiResponse::success($data, 200);
    }
}
