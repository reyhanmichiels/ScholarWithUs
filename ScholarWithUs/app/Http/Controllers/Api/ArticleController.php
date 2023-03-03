<?php

namespace App\Http\Controllers;

use App\Libraries\ApiResponse;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Article $article)
    {
        try {
            $data = [
                'message' => "Get all article",
                'data' => $article->all()
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Article $article)
    {
        try {
            $data = [
                'message' => "Article with id $article->id",
                'data' => $article
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'string|required',
            'description' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $article = new Article;
            $article->title = $request->title;
            $article->description = $request->description;
            $article->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }

        $data = [
            'message' => 'Article created',
            'data' => $article
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Article $article)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'string|required',
            'description' => 'string|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $article->title = $request->title;
            $article->description = $request->description;
            $article->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }

        $data = [
            'message' => 'Article updated',
            'data' => $article
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Article $article)
    {
        try {
            $article->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }

        $data['message'] = "Article Deleted";

        return ApiResponse::success($data, 200);
        
    }
}
