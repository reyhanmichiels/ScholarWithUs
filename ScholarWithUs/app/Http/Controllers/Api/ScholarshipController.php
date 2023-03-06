<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScholarshipController extends Controller
{
    public function index(Scholarship $scholarship)
    {
        try {
            $data = [
                'message' => "Get all scholarship",
                'data' => $scholarship->paginate(9)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Scholarship $scholarship)
    {
        try {
            $data = [
                'message' => "Scholarship with id $scholarship->id",
                'data' => $scholarship
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'string|required|unique:scholarships',
            'tag_level_id' => 'int|required',
            'tag_cost_id' => 'int|required',
            'scholarship_provider' => "string|required",
            'open_registration' => 'date|required',
            'close_registration' => 'date|required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $scholarship = new Scholarship;
            $scholarship->name = $request->name;
            $scholarship->tag_level_id = $request->tag_level_id;
            $scholarship->tag_cost_id = $request->tag_cost_id;
            $scholarship->scholarship_provider = $request->scholarship_provider;
            $scholarship->open_registration = $request->open_registration;
            $scholarship->close_registration = $request->close_registration;
            $scholarship->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Scholarship created',
            'data' => $scholarship
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'string|required|unique:scholarships,name,' . $scholarship->id,
            'tag_level_id' => 'int|required',
            'tag_cost_id' => 'int|required',
            'scholarship_provider' => "string|required",
            'open_registration' => 'date|required',
            'close_registration' => 'date|required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $scholarship->name = $request->name;
            $scholarship->tag_level_id = $request->tag_level_id;
            $scholarship->tag_cost_id = $request->tag_cost_id;
            $scholarship->scholarship_provider = $request->scholarship_provider;
            $scholarship->open_registration = $request->open_registration;
            $scholarship->close_registration = $request->close_registration;
            $scholarship->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Scholarship updated',
            'data' => $scholarship
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Scholarship $scholarship)
    {
        try {
            $scholarship->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data['message'] = "scholarship Deleted";

        return ApiResponse::success($data, 200);
    }

    public function showNew(Scholarship $scholarship)
    {
        try {
            $response = $scholarship->all()->sortBy('open_registration')->take(9);

            $data = [
                'message' => "9 newest scholarship",
                'data' => $response
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }
    
    public function filterByTag(Request $request, Scholarship $scholar)
    {
        $validate = Validator::make($request->all(), [
            'tag_country_id' => "int",
            'tag_cost_id' => "int",
            'tag_level_id' => "int"
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $country_boolean = $request->tag_country_id;
        $cost_boolean = $request->tag_cost_id;
        $level_boolean = $request->tag_level_id;

        if ($country_boolean && $cost_boolean && $level_boolean) {
            $country = $this->tag_country($request, $scholar);
            $cost = $this->tag_cost($request, $scholar);
            $level = $this->tag_level($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => $scholar->all()->only($country->intersect($cost)->intersect($level)->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean && $cost_boolean) {
            $country = $this->tag_country($request, $scholar);
            $cost = $this->tag_cost($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => $scholar->all()->only($country->intersect($cost)->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean && $level_boolean) {
            $country = $this->tag_country($request, $scholar);
            $level = $this->tag_level($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => $scholar->all()->only($country->intersect($level)->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($cost_boolean && $level_boolean) {
            $cost = $this->tag_cost($request, $scholar);
            $level = $this->tag_level($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => $scholar->all()->only($cost->intersect($level)->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean) {
            $country = $this->tag_country($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => $scholar->all()->only($country->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($cost_boolean) {
            $cost = $this->tag_cost($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => $scholar->all()->only($cost->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        if ($level_boolean) {
            $level = $this->tag_level($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => $scholar->all()->only($level->toArray())
            ];

            return ApiResponse::success($data, 200);
        }

        $data = [
            'message' => 'You dont have any filter',
            'data' => $scholar->all()
        ];
        return ApiResponse::success($data, 200);
    }

    public function searchByName(Request $request, Scholarship $scholarship)
    {
        $validate = Validator::make($request->all(), [
            'name' => "string|required"
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $id = collect();

        foreach ($scholarship->all() as $scho) {
            $name = strtolower($scho->name);
            $nameFromUser = strtolower($request->name);

            if (str_contains($name, $nameFromUser)) {
                $id->push($scho->id);
            }
        }

        $data = [
            'message' => "Search Successed",
            'data' => $scholarship->all()->only($id->toArray())
        ];

        return ApiResponse::success($data, 200);
    }

    public function seeTag(Scholarship $scholarship)
    {
        try {
            $data = [
                'message' => "Tag for scholarship with id $scholarship->id",
                'data' => [
                    'tag_level' => [
                        'id' => $scholarship->tag_level_id,
                        'name' => $scholarship->tagLevels->name,
                    ],
                    'tag_cost' => [
                        'id' => $scholarship->tag_cost_id,
                        'name' => $scholarship->tagCosts->name,
                    ],
                    'tag_country' => $scholarship->tagCountries
                ]
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 500);
        }

        return ApiResponse::success($data, 200);
    }

    private function tag_level($request, $scholar)
    {
        $response = $scholar->where('tag_level_id', $request->tag_level_id)->get('id');
        return $response->pluck('id');
    }

    private function tag_cost($request, $scholar)
    {
        $response = $scholar->where('tag_cost_id', $request->tag_cost_id)->get('id');
        return $response->pluck('id');
    }

    private function tag_country($request, $scholar)
    {
        $country = collect();
        foreach ($scholar->all() as $pro) {

            foreach ($pro->tagCountries as $tag) {

                if ($tag->pivot->tag_country_id == $request->tag_country_id) {
                    $country->push($tag->pivot->scholarship_id);
                }
            }
        }

        return $country;
    }
}
