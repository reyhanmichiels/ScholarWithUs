<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Course;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index(Program $program)
    {
        if (!Gate::allows('user-program', $program)) {
            return ApiResponse::error("Unauthorized", 403);
        }
        
        $data = [
            'message' => "Show all course with program id $program->id",
            'data' => $program->courses
        ];
        return ApiResponse::success($data, 200);
    }

    public function show(Program $program, Course $course)
    {
        if (!Gate::allows('user-program', $program)) {
            return ApiResponse::error("Unauthorized", 403);
        }

        $response = $program->courses->find($course->id);

        if (! $response) {
            return ApiResponse::error('not found', 404);
        }

        $data = [
            'message' => "Show course with id $course->id",
            'data' => $response
        ];

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {   
        if (! Gate::allows('only-admin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        $validate = Validator::make($request->all(), [
            'name' => 'string|required|unique:courses,name',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $course = new Course;
            $course->name = $request->name;
            $course->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Succesfully created course',
            'data' => $course
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Course $course)
    {   
        if (! Gate::allows('only-admin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        $validate = Validator::make($request->all(), [
            'name' => 'string|required|unique:courses,name,' . $course->id,
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $course->name = $request->name;
            $course->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Succesfully updated course',
            'data' => $course
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Course $course)
    {   
        if (! Gate::allows('only-admin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        try {
            $course->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Succesfully deleted course";

        return ApiResponse::success($data, 200);
    }

    public function attach(Program $program, Course $course)
    {   
        if (! Gate::allows('only-admin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        $test = $program->courses->where('id', $course->id);

        if (!empty($test->toArray())) {
            return ApiResponse::error('Course already in that program', 409);
        }

        try {
            $program->courses()->attach($course->id);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => "Successfully attach course id $course->id to program id $program->id",
        ];

        return ApiResponse::success($data, 201);
    }

    public function detach(Program $program, Course $course)
    {   
        if (! Gate::allows('only-admin')) {
            return ApiResponse::error("Unauthorized", 403);
        };
        
        $test = $program->courses->where('id', $course->id);

        if (empty($test->toArray())) {
            return ApiResponse::error("Course doesn't exist in that program", 409);
        }

        try {
            $program->courses()->detach($course->id);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => "Successfully detach course id $course->id from program id $program->id",
        ];

        return ApiResponse::success($data, 200);
    }
}
