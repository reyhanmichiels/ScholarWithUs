<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\FileController;
use App\Http\Resources\ArticleResource;
use App\Libraries\ApiResponse;
use App\Models\Article;
use App\Models\TagArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request, Article $article)
    {

        $tagArticleId = $request->query('tag_article_id');

        if ($tagArticleId != null) {

            $response = $article->all()->where('tag_article_id', $tagArticleId);

        } else if (Cache::has('article')) {

            $response = Cache::get('article');

        } else {

            $response = $article->all();
            Cache::put('article', $response, 3600);

        }

        $data = [
            'message' => "Show articles",
            'data' => ArticleResource::collection($response)
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

        if (!Gate::allows('isAdmin')) {

            return ApiResponse::error("Unauthorized", 403);

        };

        $validate = Validator::make($request->all(), [
            'title'             => 'required|string|unique:articles|max:20',
            'brief_description' => 'required|string',
            'description'       => 'required|string',
            'tag_article_id'    => 'required|numeric',
            'article_picture'   => 'required|file',
        ]);

        if ($validate->fails()) {

            return ApiResponse::error($validate->errors(), 409);

        }

        if (!TagArticle::find($request->tag_article_id)) {

            return ApiResponse::error('tag article not found', 404);

        }

        try {

            $imageId = Article::orderBy('id', 'desc')->first()->id + 1;
            $image = [
                'file'      => $request->file('article_picture'),
                'file_name' => "$imageId." . $request->file('article_picture')->extension(),
                'file_path' => 'article_picture'
            ];
            $url = FileController::manage($image);

            $article                    = new Article;
            $article->title             = $request->title;
            $article->brief_description = $request->brief_description;
            $article->description       = $request->description;
            $article->tag_article_id    = $request->tag_article_id;
            $article->image             = $url;
            $article->save();

            Cache::forget('article');

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

        if (!Gate::allows('isAdmin')) {

            return ApiResponse::error("Unauthorized", 403);

        };

        $validate = Validator::make($request->all(), [
            'title'             => 'required|string|max:20|unique:articles,title,' . $article->id,
            'brief_description' => 'required|string|',
            'description'       => 'required|string|',
            'tag_article_id'    => 'required|numeric',
            'article_picture'   => 'sometimes|file',
        ]);

        if ($validate->fails()) {

            return ApiResponse::error($validate->errors(), 409);

        }

        if (!TagArticle::find($request->tag_article_id)) {

            return ApiResponse::error('tag article not found', 404);

        }

        if (!empty($request->article_picture)) {

            $data = [
                'file'        => $request->file('article_picture'),
                'file_name'   =>  $article->id . "." . $request->file('article_picture')->extension(),
                'file_path'   => 'article_picture',
                'delete_file' => substr($article->image, 8)
            ];

            $url = FileController::manage($data);

        }

        try {

            $article->title             = $request->title;
            $article->brief_description = $request->brief_description;
            $article->description       = $request->description;
            $article->tag_article_id    = $request->tag_article_id;
            $article->image             = $url ?? $article->image;
            $article->save();

            Cache::forget('article');

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

        if (!Gate::allows('isAdmin')) {

            return ApiResponse::error("Unauthorized", 403);

        };

        try {

            Storage::delete(substr($article->image, 8));
            $article->delete();
            Cache::forget('article');

        } catch (\Exception $e) {

            return ApiResponse::error($e->getMessage(), 500);

        }

        $data['message'] = "Successfully deleted article";

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
