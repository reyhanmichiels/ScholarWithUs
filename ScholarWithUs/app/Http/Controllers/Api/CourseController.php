<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index(Course $course)
    {
        try {
            $data = [
                'message' => "Get all course",
                'data' => $course->all()
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Course $course)
    {
        try {
            $data = [
                'message' => "Course with id $course->id",
                'data' => $course
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'string|required|unique:courses',
            'mentor_id' => 'int|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $course = new Course;
            $course->name = $request->name;
            $course->mentor_id = $request->mentor_id;
            $course->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Course created',
            'data' => $course
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Course $course)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'string|required|unique:courses,name,' . $course->id,
            'mentor_id' => 'int|required'

        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $course->name = $request->name;
            $course->mentor_id = $request->mentor_id;
            $course->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data = [
            'message' => 'Course updated',
            'data' => $course
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Course $course)
    {
        try {
            $course->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() == "" ? $e->getCode() : 400);
        }

        $data['message'] = "Course Deleted";

        return ApiResponse::success($data, 200);
    }
}
