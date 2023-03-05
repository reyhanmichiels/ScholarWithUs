<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\TagCountry;
use Illuminate\Http\Request;

class TagCountryController extends Controller
{
    public function show(TagCountry $tagCountry)
    {
        try {
            $data = [
                'message' => "Tag Country with id $tagCountry->id",
                'data' => $tagCountry
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 500);
        }

        return ApiResponse::success($data, 200);
    }
}
