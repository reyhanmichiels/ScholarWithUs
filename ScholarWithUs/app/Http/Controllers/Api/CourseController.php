<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Course;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class CourseController extends Controller
{
    public function index(Program $program)
    {
        try {
            $data = [
                'message' => "Get all programs course with program id $program->id",
                'data' => $program->courses
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Program $program, Course $course)
    {   
        try {
            $response = $program->courses->where('id', $course->id);

            if (empty($response->toArray())) {
                return ApiResponse::error('not found', 404);
            }

            $data = [
                'message' => "Course with id $course->id",
                'data' => $response
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
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
            return ApiResponse::error($e->getMessage(), 500);
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
            return ApiResponse::error($e->getMessage(), 500);
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
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Course Deleted";

        return ApiResponse::success($data, 200);
    }

    public function attach(Program $program, Course $course)
    {   
        $test = $program->courses->where('id', $course->id);

        if (! empty($test->toArray())) {
            return ApiResponse::error('Course already in that program', 409);
        }

        try {
            $program->courses()->attach($course->id);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);  
        }

        $data = [
            'message' => "attach course with id $course->id to program with id $program->id",
        ];

        return ApiResponse::success($data, 201);
    }

    public function detach(Program $program, Course $course)
    {
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
            'message' => "detach course with id $course->id from program with id $program->id",
        ];

        return ApiResponse::success($data, 200);
    }
}
