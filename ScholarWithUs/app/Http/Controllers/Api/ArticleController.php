<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\FileController;
use App\Http\Resources\ArticleResource;
use App\Libraries\ApiResponse;
use App\Models\Article;
use App\Models\TagArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Article $article)
    {
        $data = [
            'message' => "Show all article",
            'data' => ArticleResource::collection($article->all())
        ];

        return ApiResponse::success($data, 200);
    }

    public function show(Article $article)
    {
        $data = [
            'message' => "Show article with id $article->id",
            'data' => new ArticleResource($article)
        ];

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'string|required|unique:articles|max:20',
            'brief_description' => 'string|required',
            'description' => 'string|required',
            'tag_article_id' => 'int|required',
            'article_picture' => 'file|required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        if (!TagArticle::find($request->tag_article_id)) {
            return ApiResponse::error('tag article not found', 404);
        }

        try {
            $article = new Article;
            $article->title = $request->title;
            $article->brief_description = $request->brief_description;
            $article->description = $request->description;
            $article->tag_article_id = $request->tag_article_id;
            $article->image = "temp";
            $article->save();

            $image = [
                'file' => $request->file('article_picture'),
                'file_name' =>  "$article->id." . $request->file('article_picture')->extension(),
                'file_path' => '/article_picture'
            ];

            $url = FileController::manage($image);

            $article->image = $url;
            $article->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Successfully created article',
            'data' => new ArticleResource($article)
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Article $article)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'string|required|max:20|unique:articles,title,' . $article->id,
            'brief_description' => 'string|required',
            'description' => 'string|required',
            'tag_article_id' => 'int|required',
            'article_picture' => 'file|sometimes',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        if (!TagArticle::find($request->tag_article_id)) {
            return ApiResponse::error('tag article not found', 404);
        }

        if (!empty($request->article_picture)) {
            $data = [
                'file' => $request->file('article_picture'),
                'file_name' =>  $article->id . "." . $request->file('article_picture')->extension(),
                'file_path' => '/article_picture',
                'delete_file' => substr($article->image, 9)
            ];

            $url = FileController::manage($data);
        }

        try {
            $article->title = $request->title;
            $article->brief_description = $request->brief_description;
            $article->description = $request->description;
            $article->tag_article_id = $request->tag_article_id;
            $article->image = $url ?? $article->image;
            $article->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Successfully updated article',
            'data' => new ArticleResource($article)
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Article $article)
    {
        try {
            Storage::delete('article_picture/7.svg');
            // $article->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Successfully deleted article";

        return ApiResponse::success($data, 200);
    }


    public function filterByTag(TagArticle $tagArticle)
    {
        $data = [
            'message' => "Show all article with tag $tagArticle->name",
            'data' => ArticleResource::collection($tagArticle->articles)
        ];

        return ApiResponse::success($data, 200);
    }

    public function recomend(Article $article)
    {   
        $tag = TagArticle::find($article->tagArticles->id);

        $data = [
            'message' => "Show recomend article for article with id $article->id",
            'data' => ArticleResource::collection($tag->articles()->where('id', '!=', $article->id)->take(3)->get())
        ];

        return ApiResponse::success($data, 200);
    }
}
