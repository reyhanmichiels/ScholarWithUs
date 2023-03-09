<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\TagCost;
use Illuminate\Http\Request;

class TagCostController extends Controller
{
    public function index(TagCost $tagCost)
    {
        try {
            $data = [
                'message' => "All Tag Cost",
                'data' => $tagCost->all()
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 500);
        }

        return ApiResponse::success($data, 200);
    }
}
