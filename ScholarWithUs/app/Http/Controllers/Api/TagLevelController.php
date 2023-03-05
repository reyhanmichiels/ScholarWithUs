<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\TagLevel;
use Illuminate\Http\Request;

class TagLevelController extends Controller
{
    public function show(TagLevel $tagLevel)
    {
        try {
            $data = [
                'message' => "Tag Level with id $tagLevel->id",
                'data' => $tagLevel
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 500);
        }

        return ApiResponse::success($data, 200);
    }
}
