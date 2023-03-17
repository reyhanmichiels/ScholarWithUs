<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\TagArticle;
use Illuminate\Http\Request;

class ArticleTagArticleController extends Controller
{
    public function index(TagArticle $tagArticle)
    {
        $data = [
            'message' => "Show all article with tag $tagArticle->name",
            'data' => $tagArticle->articles
        ];

        return ApiResponse::success($data, 200);
    }
}
