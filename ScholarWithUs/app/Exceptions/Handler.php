<?php

namespace App\Exceptions;

use App\Libraries\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Exception $e, $request) {

            if ($e instanceof NotFoundHttpException && str_contains($e->getMessage(), 'model')) {
                $model = explode("/", $request->path());
                $model = $model[1];
                return ApiResponse::error("$model id not found", 409);
            } 

            if ($e instanceof NotFoundHttpException) {
                return ApiResponse::error("Route not found", 404);
            } 

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ],  500);
        });
    }
}
