<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Course;
use App\Models\Material;
use App\Models\Program;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProgressController extends Controller
{
    public function show(Program $program)
    {
        $user = User::find(Auth::user()->id);

        if ($user->programs->find($program->id) == null) {
            return ApiResponse::error("User doesn't have that program", 409);
        }

        $materialAmount = 0;
        foreach ($program->courses as $course) {
            $materialAmount += $course->materials()->count();
        }

        $materialFinish = UserProgress::where([['user_id', $user->id], ['program_id', $program->id]])->count();

        $data = [
            'message' => "Show user $user->id progress in progam $program->id",
            'data' => $materialFinish / $materialAmount * 100 . "%"
        ];

        return ApiResponse::success($data, 200);
    }

    public function store(Program $program, Course $course, Material $material)
    {
        $user = User::find(Auth::user()->id);

        if ($user->programs->find($program->id) == null) {
            return ApiResponse::error("User doesn't have that program", 409);
        }

        if ($program->courses->find($course->id) == null) {
            return ApiResponse::error("Program doesn't have that course", 409);
        }

        if ($course->materials->find($material->id) == null) {
            return ApiResponse::error("Course doesn't have that material", 409);
        }

        try {
            $userprogress = new UserProgress;
            $userprogress->user_id = $user->id;
            $userprogress->program_id = $program->id;
            $userprogress->course_id = $course->id;
            $userprogress->material_id = $material->id;
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $materialFinish = UserProgress::where([['user_id', $user->id], ['program_id', $program->id], ['course_id', $course->id], ['material_id', $material->id]])->get();

        if (!empty($materialFinish->toArray())) {
            return ApiResponse::error("User already finished this material", 409);
        }

        $data['message'] = "Marked this material to finish";
        return ApiResponse::success($data, 201);
    }

    public function check(Program $program, Course $course, Material $material)
    {
        $user = User::find(Auth::user()->id);


        if ($user->programs->find($program->id) == null) {
            return ApiResponse::error("User doesn't have that program", 409);
        }

        if ($program->courses->find($course->id) == null) {
            return ApiResponse::error("Program doesn't have that course", 409);
        }

        if ($course->materials->find($material->id) == null) {
            return ApiResponse::error("Course doesn't have that material", 409);
        }

        $materialFinish = UserProgress::where([['user_id', $user->id], ['program_id', $program->id], ['course_id', $course->id], ['material_id', $material->id]])->get();

        if (empty($materialFinish->toArray())) {
            $data['message'] = "User not yet finished this material";
            return ApiResponse::success($data, 200);
        }

        $data['message'] = "User already finished this material";
        return ApiResponse::success($data, 200);
    }
}
