<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\TagLevel;
use Illuminate\Http\Request;

class TagLevelController extends Controller
{
    public function index(TagLevel $tagLevel)
    {
        $data = [
            'message' => "All Tag Level",
            'data' => $tagLevel->all()
        ];

        return ApiResponse::success($data, 200);
    }
}
