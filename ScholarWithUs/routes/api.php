<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\ScholarshipController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\DiscussionController;
use App\Http\Controllers\Api\TagCostController;
use App\Http\Controllers\Api\TagCountryController;
use App\Http\Controllers\Api\TagLevelController;
use App\Http\Controllers\MentorController;
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
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{course}', [CourseController::class, 'show']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::put('/courses/{course}', [CourseController::class, 'update']);
    Route::delete('/courses/{course}', [CourseController::class, 'destroy']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    Route::post('/programs', [ProgramController::class, 'store']);
    Route::put('/programs/{program}', [ProgramController::class, 'update']);
    Route::delete('/programs/{program}', [ProgramController::class, 'destroy']);
    Route::post('/programs/buy', [ProgramController::class, 'buy']);

    Route::post('/tags', [TagController::class, 'store']);
    Route::put('/tags/{tag}', [TagController::class, 'update']);
    Route::delete('/tags/{tag}', [TagController::class, 'destroy']);

    Route::post('/mentors', [MentorController::class, 'store']);
    Route::put('/mentors/{mentor}', [MentorController::class, 'update']);
    Route::delete('/mentors/{mentor}', [MentorController::class, 'destroy']);

    Route::post('/scholarships', [ScholarshipController::class, 'store']);
    Route::put('/scholarships/{scholarship}', [ScholarshipController::class, 'update']);
    Route::delete('/scholarships/{scholarship}', [ScholarshipController::class, 'destroy']);

    Route::post('/replies', [ReplyController::class, 'store']);
    Route::put('/replies/{reply}', [ReplyController::class, 'update']);
    Route::delete('/replies/{reply}', [ReplyController::class, 'destroy']);

    Route::post('/discussions', [DiscussionController::class, 'store']);
    Route::put('/discussions/{discussion}', [DiscussionController::class, 'update']);
    Route::delete('/discussions/{discussion}', [DiscussionController::class, 'destroy']);

    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{article}', [ArticleController::class, 'update']);
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{article}', [ArticleController::class, 'show']);

Route::get('/discussions', [DiscussionController::class, 'index']);
Route::get('/discussions/{discussion}', [DiscussionController::class, 'show']);

Route::get('/replies', [ReplyController::class, 'index']);
Route::get('/replies/{reply}', [ReplyController::class, 'show']);

Route::get('/scholarships', [ScholarshipController::class, 'index']);
Route::get('/scholarships/new', [ScholarshipController::class, 'showNew']);
Route::get('/scholarships/{scholarship}/tag', [ScholarshipController::class, 'seeTag']);
Route::get('/scholarships/{scholarship}', [ScholarshipController::class, 'show']);

Route::get('/mentors', [MentorController::class, 'index']);
Route::get('/mentors/new', [MentorController::class, 'showNew']);
Route::get('/mentors/{mentor}', [MentorController::class, 'show']);

Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{tag}', [TagController::class, 'show']);

Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/programs/new', [ProgramController::class, 'showNew']);
Route::get('/programs/search', [ProgramController::class, 'searchByName']);
Route::get('/programs/filter', [ProgramController::class, 'filterByTag']);
Route::get('/programs/{program}/tag', [ProgramController::class, 'seeTag']);
Route::get('/programs/{program}', [ProgramController::class, 'show']);

Route::get('/tagCountries/{tagCountry}', [TagCountryController::class, 'show']);

Route::get('/tagLevels/{tagLevel}', [TagLevelController::class, 'show']);

Route::get('/tagCosts/{tagCost}', [TagCostController::class, 'show']);
