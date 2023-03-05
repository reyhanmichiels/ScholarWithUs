<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index(Tag $tag)
    {
        try {
            $data = [
                'message' => "Get all tag",
                'data' => $tag->all()
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Tag $tag)
    {
        try {
            $data = [
                'message' => "Tag with id $tag->id",
                'data' => $tag
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'string|required|unique:tags'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $tag = new Tag;
            $tag->name = $request->name;
            $tag->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'tag created',
            'data' => $tag
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Tag $tag)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'string|required:unique:tags'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $tag->name = $request->name;
            $tag->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Tag updated',
            'data' => $tag
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data['message'] = "Tag Deleted";

        return ApiResponse::success($data, 200);
    }
}
