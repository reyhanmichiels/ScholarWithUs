<?php

namespace App\Http\Controllers;

use App\Libraries\ApiResponse;
use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    public function index(Course $course)
    {
        try {
            $data = [
                'message' => "All material from course with course id $course->id",
                'data' => $course->materials
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Course $course, Material $material)
    {
        try {
            $response = $course->materials->where('id', $material->id);

            if (empty($response->toArray())) {
                return ApiResponse::error("Material doesn't exist", 404);
            }

            $data = [
                'message' => "Material with id $material->id from course with course id $course->id",
                'data' => $response
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request, Course $course)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'video' => 'required|string',
            'modul' => 'required|file'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $video = str_replace('/view', '/preview', $request->video);

        try {
            $material = new Material;
            $material->course_id = $course->id;
            $material->name = $request->name;
            $material->video = $video;
            $material->save();

            $modul = $request->file('modul');

            $file = [
                'file' => $modul,
                'file_name' => $material->id . "." . $modul->extension(),
                'file_path' => 'material_modul'
            ];

            $url = FileController::manage($file);

            $material->modul = $url;
            $material->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => "Material succesfully created",
            'data' => $material
        ];

        return ApiResponse::success($data, 201);
    }

    public function update(Request $request, Course $course, Material $material)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'video' => 'required|string',
            'modul' => 'required|file'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $response = $course->materials->where('id', $material->id);

        if (empty($response->toArray())) {
            return ApiResponse::error("Material doesn't exist", 404);
        }

        $file = [
            'file' => $request->file('modul'),
            'file_name' => $material->id . "." . $request->file('modul')->extension(),
            'file_path' => 'material_modul',
            'file_delete' => substr($material->modul, 9)
        ];

        $url = FileController::manage($file);
        try {
            $material->course_id = $course->id;
            $material->name = $request->name;
            $material->video = str_replace('/view', '/preview', $request->video);
            $material->modul = $url;
            $material->save();            
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Succesfully update material',
            'data' => $material
        ];

        return ApiResponse::success($data, 200);
    }

    public function destroy(Course $course, Material $material)
    {
        $response = $course->materials->where('id', $material->id);

        if (empty($response->toArray())) {
            return ApiResponse::error("Material doesn't exist", 404);
        }

        try {
            $material->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Succesfully delete material'
        ];

        return ApiResponse::success($data, 200);
    }
}
