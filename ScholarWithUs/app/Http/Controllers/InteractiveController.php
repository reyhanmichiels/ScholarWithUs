<?php

namespace App\Http\Controllers;

use App\Http\Resources\InteractiveResource;
use App\Libraries\ApiResponse;
use App\Models\Interactive;
use App\Models\Program;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InteractiveController extends Controller
{
    public function show(Program $program)
    {   
        $user = User::find(Auth::user()->id);

        if ($user->programs->find($program->id) == null) {
            return ApiResponse::error("User doesn't have that program", 404);
        }

        $todayDate = Carbon::parse(Carbon::now())->format('d m Y');
        
        $interactive = Interactive::where('program_id', $program->id)->orderBy('date')->get();

        if (empty($interactive->toArray())) {
            return ApiResponse::success("Schedule doesn't exist", 404);
        }

        $data = [
            'message' => "Show user next interactive class schedule",
            'data' => $interactive->where('date', '>=', $todayDate)->take(1) 
        ];

        return ApiResponse::success($data, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'date' => 'date|required',
            'start' => 'time|required',
            'finish' => 'time|required', 
            'zoom' => 'string|required', 
            'program_id' => 'int|required'
        ]);

        if ($validate->fails()) {
            return ApiResponse::error($validate->errors(), 409);
        }

        try {
            $interactive = new Interactive;
            $interactive->program_id = $request->program_id;
            $interactive->date = $request->date;
            $interactive->start = $request->start;
            $interactive->finish = $request->finish;
            $interactive->zoom = $request->zoom;
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
        try {
            $interactive->delete();
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        $data['message'] = "Successfully deleted interactive schedule";

        return ApiResponse::success($data, 200);
    }
}
