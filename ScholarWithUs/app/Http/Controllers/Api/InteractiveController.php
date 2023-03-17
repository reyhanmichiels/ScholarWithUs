<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InteractiveResource;
use App\Libraries\ApiResponse;
use App\Models\Interactive;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class InteractiveController extends Controller
{
    public function show(Program $program)
    {   
        if (!Gate::allows('user-program', $program)) {
            return ApiResponse::error("Unauthorized", 403);
        }

        $todayDate = Carbon::parse(Carbon::now())->format('d m Y');
        
        $interactive = Interactive::orderBy('date')->where([['program_id', $program->id], ['date', '>=', $todayDate]])->take(1)->get();

        if (empty($interactive->toArray())) {
            return ApiResponse::error("Schedule doesn't exist", 404);
        }

        $data = [
            'message' => "Show user next interactive class schedule",
            'data' => InteractiveResource::collection($interactive)
        ];

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {   
        if (! Gate::allows('only-admin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        $validate = Validator::make($request->all(), [
            'date' => 'date|required',
            'start' => 'date_format:H:i|required',
            'zoom' => 'string|required', 
            'program_id' => 'numeric|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        if (! Program::find($request->program_id)) {
            return ApiResponse::error("Program not found", 404);
        }

        try {
            $interactive = new Interactive;
            $interactive->program_id = $request->program_id;
            $interactive->date = $request->date;
            $interactive->start = $request->start;
            $interactive->finish = Carbon::parse($request->start)->addHour();
            $interactive->zoom = $request->zoom;
            $interactive->save();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data = [
            'message' => "Succesfuly created interactive schedule",
            'data' => new InteractiveResource($interactive) 
        ];

        return ApiResponse::success($data, 201);
    }

    public function destroy(Interactive $interactive)
    {
        // if (! Gate::allows('only-admin')) {
        //     return ApiResponse::error("Unauthorized", 403);
        // };

        try {
            $interactive->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Successfully deleted interactive schedule";

        return ApiResponse::success($data, 200);
    }
}
