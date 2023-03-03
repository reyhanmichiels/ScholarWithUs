<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\ScholarshipController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ArticleController;
use App\Models\Course;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/courses', [Course::class, 'index']);
    Route::get('/courses/{course}', [Course::class, 'show']);
    Route::post('/courses', [Course::class, 'store']);
    Route::put('/courses/{course}', [Course::class, 'update']);
    Route::delete('/courses/{course}', [Course::class, 'destroy']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{article}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{article}', [UserController::class, 'update']);
    Route::delete('/users/{article}', [UserController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{article}', [ArticleController::class, 'show']);
Route::post('/articles', [ArticleController::class, 'store']);
Route::put('/articles/{article}', [ArticleController::class, 'update']);
Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);

Route::get('/discussions', [Discussion::class, 'index']);
Route::get('/discussions/{discussion}', [Discussion::class, 'show']);
Route::post('/discussions', [Discussion::class, 'store']);
Route::put('/discussions/{discussion}', [Discussion::class, 'update']);
Route::delete('/discussions/{discussion}', [Discussion::class, 'destroy']);

Route::get('/replies', [ReplyController::class, 'index']);
Route::get('/replies/{reply}', [ReplyController::class, 'show']);
Route::post('/replies', [ReplyController::class, 'store']);
Route::put('/replies/{reply}', [ReplyController::class, 'update']);
Route::delete('/replies/{reply}', [ReplyController::class, 'destroy']);

Route::get('/scholarships', [ScholarshipController::class, 'index']);
Route::get('/scholarships/{scholarship}', [ScholarshipController::class, 'show']);
Route::post('/scholarships', [ScholarshipController::class, 'store']);
Route::put('/scholarships/{scholarship}', [ScholarshipController::class, 'update']);
Route::delete('/scholarships/{scholarship}', [ScholarshipController::class, 'destroy']);

Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{tag}', [TagController::class, 'show']);
Route::post('/tags', [TagController::class, 'store']);
Route::put('/tags/{tag}', [TagController::class, 'update']);
Route::delete('/tags/{tag}', [TagController::class, 'destroy']);

Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/programs/{program}', [ProgramController::class, 'show']);
Route::post('/programs', [ProgramController::class, 'store']);
Route::put('/programs/{program}', [ProgramController::class, 'update']);
Route::delete('/programs/{program}', [ProgramController::class, 'destroy']);
Route::post('/programs/buy', [ProgramController::class, 'buy']);

