<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScholarshipResource;
use App\Libraries\ApiResponse;
use App\Models\Scholarship;
use App\Models\TagCost;
use App\Models\TagLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ScholarshipController extends Controller
{
    public function index(Scholarship $scholarship)
    {
        if (Cache::has('scholar')) {
            $response = Cache::get('scholar');
        } else {
            $response = $scholarship->all();
            Cache::put('scholar', $response, 3600);
        }

        $data = [
            'message' => "Show all scholarship",
            'data' => ScholarshipResource::collection($response)
        ];

        return ApiResponse::success($data, 200);
    }

    public function show(Scholarship $scholarship)
    {
        $data = [
            'message' => "Show scholarship with id $scholarship->id",
            'data' => new ScholarshipResource($scholarship)
        ];

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        $validate = Validator::make($request->all(), [
            'name'                  => 'string|required|unique:scholarships',
            'tag_level_id'          => 'numeric|required',
            'tag_cost_id'           => 'numeric|required',
            'description'           => 'string|required',
            'university'            => 'string|required',
            'study_program'         => 'string|required',
            'benefit'               => 'string|required',
            'age'                   => 'numeric|required',
            'gpa'                   => 'decimal:2|required',
            'english_test'          => 'string|required',
            'other_language_test'   => 'string|required',
            'standarized_test'      => 'string|required',
            'documents'             => 'string|required',
            'other'                 => 'string|sometimes',
            'detail_information'    => 'string|required',
            'scholarship_provider'  => "string|required",
            'image'                 => 'required|file',
            'open_registration'     => 'date|required',
            'close_registration'    => 'date|required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $tag_level = TagLevel::find($request->tag_level_id);
        if (!$tag_level) {
            return ApiResponse::error('tag level not found', 404);
        }

        $tag_cost = TagCost::find($request->tag_cost_id);
        if (!$tag_cost) {
            return ApiResponse::error('tag cost not found', 404);
        }

        try {
            $scholarship = new Scholarship;
            $scholarship->name = $request->name;
            $scholarship->tag_level_id = $request->tag_level_id;
            $scholarship->tag_cost_id = $request->tag_cost_id;
            $scholarship->scholarship_provider = $request->scholarship_provider;
            $scholarship->description = $request->description;
            $scholarship->university = $request->university;
            $scholarship->study_program = $request->study_program;
            $scholarship->benefit = $request->benefit;
            $scholarship->age = $request->age;
            $scholarship->gpa = $request->gpa;
            $scholarship->english_test = $request->english_test;
            $scholarship->other_language_test = $request->other_language_test;
            $scholarship->standarized_test = $request->standarized_test;
            $scholarship->documents = $request->documents ?? null;
            $scholarship->other = $request->other;
            $scholarship->detail_information = $request->scholarship_provider;
            $scholarship->open_registration = $request->open_registration;
            $scholarship->close_registration = $request->close_registration;
            $scholarship->image = "temp";
            $scholarship->save();

            $image = [
                'file' => $request->file('image'),
                'file_name' => $scholarship->id . "." . $request->file('image')->extension(),
                'file_path' => 'scholarship_picture'
            ];

            $url = FileController::manage($image);

            $scholarship->image = $url;
            $scholarship->save();
            Cache::forget('scholar');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Successfully created scholarship',
            'data' => new ScholarshipResource($scholarship)
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        if (!Gate::allows('isAdmin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        $validate = Validator::make($request->all(), [
            'name'                  => 'string|required|unique:scholarships,name,' . $scholarship->id,
            'tag_level_id'          => 'int|required',
            'tag_cost_id'           => 'int|required',
            'description'           => 'string|required',
            'university'            => 'string|required',
            'study_program'         => 'string|required',
            'benefit'               => 'string|required',
            'age'                   => 'integer|required',
            'gpa'                   => 'decimal:2|required',
            'english_test'          => 'string|required',
            'other_language_test'   => 'string|required',
            'standarized_test'      => 'string|required',
            'documents'             => 'string|required',
            'other'                 => 'string|sometimes',
            'detail_information'    => 'string|required',
            'scholarship_provider'  => "string|required",
            'open_registration'     => 'date|required',
            'close_registration'    => 'date|required',
            'image'                 => 'sometimes|file'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $tag_level = TagLevel::find($request->tag_level_id);
        if (!$tag_level) {
            return ApiResponse::error('tag level not found', 404);
        }

        $tag_cost = TagCost::find($request->tag_cost_id);
        if (!$tag_cost) {
            return ApiResponse::error('tag cost not found', 404);
        }

        if (!empty($request->image)) {
            $image = [
                'file' => $request->file('image'),
                'file_name' => $scholarship->id . "." . $request->file('image')->extension(),
                'file_path' => 'scholarship_picture',
                'delete' => substr($scholarship->image, 8)
            ];

            $url = FileController::manage($image);
        }

        try {
            $scholarship->name = $request->name;
            $scholarship->tag_level_id = $request->tag_level_id;
            $scholarship->tag_cost_id = $request->tag_cost_id;
            $scholarship->scholarship_provider = $request->scholarship_provider;
            $scholarship->description = $request->description;
            $scholarship->university = $request->university;
            $scholarship->study_program = $request->study_program;
            $scholarship->benefit = $request->benefit;
            $scholarship->age = $request->age;
            $scholarship->gpa = $request->gpa;
            $scholarship->english_test = $request->english_test;
            $scholarship->other_language_test = $request->other_language_test;
            $scholarship->standarized_test = $request->standarized_test;
            $scholarship->documents = $request->documents ?? null;
            $scholarship->other = $request->other;
            $scholarship->detail_information = $request->scholarship_provider;
            $scholarship->open_registration = $request->open_registration;
            $scholarship->close_registration = $request->close_registration;
            $scholarship->image = $url ?? $scholarship->image;
            $scholarship->save();
            Cache::forget('scholar');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Scholarship updated',
            'data' => new ScholarshipResource($scholarship)
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Scholarship $scholarship)
    {
        if (!Gate::allows('isAdmin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        try {
            Storage::delete(substr($scholarship->image, 8));
            $scholarship->delete();
            Cache::forget('scholar');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Successfully deleted scholarship";

        return ApiResponse::success($data, 200);
    }

    public function showNew(Scholarship $scholarship)
    {
        try {
            $response = $scholarship->orderByDesc('open_registration')->take(9)->get();

            $data = [
                'message' => "9 newest scholarship",
                'data' => ScholarshipResource::collection($response)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
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

        $country_boolean = $request->tagsd;
        $cost_boolean = $request->tag_cost_id;
        $level_boolean = $request->tag_level_id;

        if ($country_boolean && $cost_boolean && $level_boolean) {
            $country = $this->tag_country($request, $scholar);
            $cost = $this->tag_cost($request, $scholar);
            $level = $this->tag_level($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => ScholarshipResource::collection($scholar->all()->only($country->intersect($cost)->intersect($level)->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean && $cost_boolean) {
            $country = $this->tag_country($request, $scholar);
            $cost = $this->tag_cost($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => ScholarshipResource::collection($scholar->all()->only($country->intersect($cost)->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean && $level_boolean) {
            $country = $this->tag_country($request, $scholar);
            $level = $this->tag_level($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => ScholarshipResource::collection($scholar->all()->only($country->intersect($level)->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($cost_boolean && $level_boolean) {
            $cost = $this->tag_cost($request, $scholar);
            $level = $this->tag_level($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => ScholarshipResource::collection($scholar->all()->only($cost->intersect($level)->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($country_boolean) {
            $country = $this->tag_country($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => ScholarshipResource::collection($scholar->all()->only($country->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($cost_boolean) {
            $cost = $this->tag_cost($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => ScholarshipResource::collection($scholar->all()->only($cost->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        if ($level_boolean) {
            $level = $this->tag_level($request, $scholar);

            $data = [
                'message' => 'Scholarship after filter',
                'data' => ScholarshipResource::collection($scholar->all()->only($level->toArray()))
            ];

            return ApiResponse::success($data, 200);
        }

        $data = [
            'message' => 'You dont have any filter',
            'data' => ScholarshipResource::collection($scholar->all())
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
            'data' => ScholarshipResource::collection($scholarship->all()->only($id->toArray()))
        ];

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
