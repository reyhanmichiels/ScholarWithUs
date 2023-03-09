<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\TagCountry;
use App\Models\TagLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagCountryController extends Controller
{
    public function index(TagCountry $tagCountry)
    {
        try {
            $data = [
                'message' => "All Tag Country",
                'data' => $tagCountry->all()
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {   
        $validate = Validator::make($request->all(), [
            'name' => 'string|required|unique'
        ]);

        try {
            $tagCountry = new TagCountry;
            $tagCountry-> name = $request->name;
            $tagCountry->save();
        } catch (\Exception $e) {
            ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => "created success",
            'data' => $tagCountry
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, TagCountry $tagCountry)
    {   
        $validate = Validator::make($request->all(), [
            'name' => 'string|required|unique'
        ]);

        try {
            $tagCountry-> name = $request->name;
            $tagCountry->save();
        } catch (\Exception $e) {
            ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => "update success",
            'data' => $tagCountry
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(TagLevel $tagLevel)
    {
        try {
            $tagLevel->delete();
        } catch (\Exception $e) {
            ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => "delete success",
        ];

        return ApiResponse::success($data, 200);
    }
}
