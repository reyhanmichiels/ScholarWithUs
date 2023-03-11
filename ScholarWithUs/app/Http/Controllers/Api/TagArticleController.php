<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\TagArticle;
use Illuminate\Http\Request;

class TagArticleController extends Controller
{
    public function index(TagArticle $tagArticle)
    {
        $data = [
            'message' => 'Show all tag article',
            'data' => $tagArticle->all()
        ];

        return ApiResponse::success($data, 200);
    }
}
