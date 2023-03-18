<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Libraries\ApiResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    public function index()
    {
        if (!Gate::allows('only-admin')) {
            return ApiResponse::error("Unauthorized", 403);
        };

        $user = Auth::user();

        $data = [
            'message' => "All $user->name transaction",
            'data' => TransactionResource::collection($user->transactions)
        ];

        return ApiResponse::success($data, 200);
    }

    public function show(Transaction $transaction)
    {
        if (!Gate::allows('only-admin')) {
            return ApiResponse::error("Unauthorized", 403);
        };
        
        $user = Auth::user();

        if ($user->id != $transaction->user_id) {
            return ApiResponse::error('not found', 404);
        }

        $user = Auth::user();

        $data = [
            'message' => "All $user->name transaction",
            'data' => new TransactionResource($transaction)
        ];


        return ApiResponse::success($data, 200);
    }
}
