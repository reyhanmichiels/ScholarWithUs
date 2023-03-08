<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Libraries\ApiResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();

            $data = [
                'message' => "All $user->name transaction",
                'data' => TransactionResource::collection($user->transactions)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() != 0 ? $e->getCode() : 500);
        }

        return ApiResponse::success($data, 200);
    }

    public function show(Transaction $transaction)
    {
        $user = Auth::user();

        if ($user->id != $transaction->user_id) {
            return ApiResponse::error('not found', 404);
        }

        try {
            $user = Auth::user();

            $data = [
                'message' => "All $user->name transaction",
                'data' => new TransactionResource($transaction)
            ];
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode() != 0 ? $e->getCode() : 500);
        }

        return ApiResponse::success($data, 200);
    }
}
