<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\Consultation;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'program_id' => 'required|numeric',
            'type' => 'required|string|in:asking_mentor,review_document',
            'date' => 'required|date',
            'start' => 'required|string|in:09:00,13:00,15:00',
            'document' => 'sometimes|file',
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $program = Program::find($request->program_id);

        if (!$program) {
            return ApiResponse::error("Program not found", 404);
        }

        if (!Gate::allows('user-program', $program)) {
            return ApiResponse::error("Unauthorized", 403);
        }

        try {
            $consultation = new Consultation;
            $consultation->program_id = $request->program_id;
            $consultation->user_id = Auth::user()->id;
            $consultation->type = $request->type;
            $consultation->date = $request->date;
            $consultation->start = $request->start;
            $consultation->finish = Carbon::parse($request->start)->addHour();
            $consultation->save();
            if ($request->type == "review_document") {
                $data = [
                    'file' => $request->file('document'),
                    'file_name' =>  $consultation->id . "." . $request->file('document')->extension(),
                    'file_path' => 'consultation_document',
                    'delete_file' => substr($consultation->image, 8)
                ];

                $url = FileController::manage($data);
                $consultation->document = $url;
                $consultation->save();
            }
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => 'Successfully created mentoring schedule',
            'data' => $consultation
        ];

        return ApiResponse::success($data, 201);
    }

    public function available(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'program_id' => 'required|numeric'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        $program = Program::find($request->program_id);

        if (!$program) {
            return ApiResponse::error("Program not found", 404);
        }

        if (!Gate::allows('user-program', $program)) {
            return ApiResponse::error("Unauthorized", 403);
        }

        $date = collect();

        for ($i = 3; $i <= 5; $i++) {
            $findDate =  Carbon::parse(Carbon::now()->addDays($i))->format('Y-m-d');

            $consultation = Consultation::where([['program_id', $program->id], ['date', $findDate], ['start', '09:00']])->get();
            if (empty($consultation->toArray())) {
                $date = $date->merge([['date' => $findDate, 'time' => '09:00']]);
            }

            $consultation = Consultation::where([['program_id', $program->id], ['date', $findDate], ['start', '13:00']])->get();
            if (empty($consultation->toArray())) {
                $date = $date->merge([['date' => $findDate, 'time' => '13:00']]);
            }

            $consultation = Consultation::where([['program_id', $program->id], ['date', $findDate], ['start', '15:00']])->get();
            if (empty($consultation->toArray())) {
                $date = $date->merge([['date' => $findDate, 'time' => '15:00']]);
            }
        }

        $data = [
            'message' => "Show all available time",
            'data' => $date
        ];

        return ApiResponse::success($data, 200);
    }
}
