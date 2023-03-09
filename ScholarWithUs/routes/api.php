<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\ScholarshipController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ArticleTagArticleController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\DiscussionController;
use App\Http\Controllers\Api\TagCostController;
use App\Http\Controllers\Api\TagCountryController;
use App\Http\Controllers\Api\TagLevelController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\TransactionController;
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
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/tags', [TagController::class, 'store']);
    Route::put('/tags/{tag}', [TagController::class, 'update']);
    Route::delete('/tags/{tag}', [TagController::class, 'destroy']);

    Route::post('/mentors', [MentorController::class, 'store']);
    Route::put('/mentors/{mentor}', [MentorController::class, 'update']);
    Route::delete('/mentors/{mentor}', [MentorController::class, 'destroy']);

    Route::post('/scholarships', [ScholarshipController::class, 'store']);
    Route::put('/scholarships/{scholarship}', [ScholarshipController::class, 'update']);
    Route::delete('/scholarships/{scholarship}', [ScholarshipController::class, 'destroy']);

    Route::post('/discussions/{discussion}/replies    ', [ReplyController::class, 'store']);
    Route::delete('/discussions/{discussion}/replies/{reply}', [ReplyController::class, 'destroy']);

    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{article}', [ArticleController::class, 'update']);
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);

    Route::post('/discussions', [DiscussionController::class, 'store']);
    Route::delete('/discussions/{discussion}', [DiscussionController::class, 'destroy']);

    Route::post('/programs', [ProgramController::class, 'store']);
    Route::put('/programs/{program}', [ProgramController::class, 'update']);
    Route::delete('/programs/{program}', [ProgramController::class, 'destroy']);
    Route::post('/programs/{program}/buy', [ProgramController::class, 'buy']);

    Route::get('/programs/{program}/courses', [CourseController::class, 'index']);
    Route::get('/programs/{program}/courses/{course}', [CourseController::class, 'show']);
    Route::post('/programs/{program}/courses/{course}', [CourseController::class, 'attach']);
    Route::delete('/programs/{program}/courses/{course}', [CourseController::class, 'detach']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::put('/courses/{course}', [CourseController::class, 'update']);
    Route::delete('/courses/{course}', [CourseController::class, 'destroy']);

    Route::get('/users/transactions', [TransactionController::class, 'index']);
    Route::get('/users/transactions/{transaction}', [TransactionController::class, 'show']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    Route::post('/tagCountries', [TagCountryController::class, 'store']);
    Route::put('/tagCountries/{tagCountry}', [TagCountryController::class, 'update']);
    Route::delete('/tagCountries/{tagCountry}', [TagCountryController::class, 'destroy']);
});

Route::get('/tagCountries', [TagCountryController::class, 'index']);

Route::get('/tagLevels', [TagLevelController::class, 'index']);

Route::get('/tagCosts', [TagCostController::class, 'index']);

Route::get('tagArticles/{tagArticle}/articles', [ArticleTagArticleController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/discussions', [DiscussionController::class, 'index']);
Route::get('/discussions/{discussion}', [DiscussionController::class, 'show']);

Route::get('/discussions/{discussion}/replies', [ReplyController::class, 'index']);
Route::get('/discussions/{discussion}/replies/{reply}', [ReplyController::class, 'show']);

Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{tag}', [TagController::class, 'show']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{article}', [ArticleController::class, 'show']);
Route::get('/articles/tagArticles/{tagArticle}', [ArticleController::class, 'filterByTag']);

Route::get('/mentors', [MentorController::class, 'index']);
Route::get('/mentors/new', [MentorController::class, 'showNew']);
Route::get('/mentors/{mentor}', [MentorController::class, 'show']);

Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/programs/new', [ProgramController::class, 'showNew']);
Route::get('/programs/search', [ProgramController::class, 'searchByName']);
Route::get('/programs/filter', [ProgramController::class, 'filterByTag']);
Route::get('/programs/{program}', [ProgramController::class, 'show']);
Route::post('/midtrans/notif-hook', ProgramController::class);


Route::get('/scholarships', [ScholarshipController::class, 'index']);
Route::get('/scholarships/new', [ScholarshipController::class, 'showNew']);
Route::get('/scholarships/filter', [ScholarshipController::class, 'filterByTag']);
Route::get('/scholarships/search', [ScholarshipController::class, 'searchByName']);
Route::get('/scholarships/{scholarship}', [ScholarshipController::class, 'show']);
