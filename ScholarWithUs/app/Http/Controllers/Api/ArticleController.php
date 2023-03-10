<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Http\Resources\ArticleResource;
use App\Libraries\ApiResponse;
use App\Models\Article;
use App\Models\TagArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Article $article)
    {
        try {
            $data = [
                'message' => "Get all article",
            'data' => ArticleResource::collection($article->all())
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Article $article)
    {
        try {
            $data = [
                'message' => "Article with id $article->id",
                'data' => new ArticleResource($article)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'string|required|unique:articles',
            'brief_description' => 'string|required',
            'description' => 'string|required',
            'tag_article_id' => 'int|required',
            'article_picture' => 'file|required',
        ]);
        
        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }
        
        $test = TagArticle::find($request->tag_article_id);

        if (! $test) {
            return ApiResponse::error('tag article not found', 404);
        }

        try {
            $article = new Article;
            $article->title = $request->title;
            $article->brief_description = $request->brief_description;
            $article->description = $request->description;
            $article->tag_article_id = $request->tag_article_id;
            $article->save();

            $image = $request->file('article_picture');
            $data = [
                'file' => $image,
                'file_name' =>  "$article->id." . $image->extension(),
                'file_path' => '/article_picture'
            ];

            $url = FileController::manage($data);

            $article->image = $url;
            $article->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Article created',
            'data' => new ArticleResource($article)
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Article $article)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'string|required|unique:articles,title,' . $article->id,
            'brief_description' => 'string|required',
            'description' => 'string|required',
            'tag_article_id' => 'int|required',
            'article_picture' => 'file|sometimes',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $delete = substr($article->image, 9);

        $image = $request->file('article_picture');
        
        $data = [
            'file' => $image,
            'file_name' =>  $article->id . "." . $image->extension(),
            'file_path' => '/article_picture',
            'delete_file' => $delete
        ];

        $url = FileController::manage($data);

        $test = TagArticle::find($request->tag_article_id);

        if (! $test) {
            return ApiResponse::error('tag article not found', 404);
        }

        try {
            $article->title = $request->title;
            $article->brief_description = $request->brief_description;
            $article->description = $request->description;
            $article->tag_article_id = $request->tag_article_id;
            $article->image = $url;
            $article->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Article updated',
            'data' => new ArticleResource($article)
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Article $article)
    {
        try {
            $article->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Article Deleted";

        return ApiResponse::success($data, 200);
    }


    public function filterByTag(TagArticle $tagArticle)
    {
        try {
            $data = [
                'message' => "Get all article with tag $tagArticle->name",
                'data' => ArticleResource::collection($tagArticle->articles)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }
}
