<?php

use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\ScholarshipController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ArticleTagArticleController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\DiscussionController;
use App\Http\Controllers\Api\TagCostController;
use App\Http\Controllers\Api\TagCountryController;
use App\Http\Controllers\Api\TagLevelController;
use App\Http\Controllers\Api\UserProgramController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\MentorController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserProgressController;
use App\Http\Controllers\Api\InteractiveController;
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

    Route::controller(ReplyController::class)->group(function () {
        Route::post('/discussions/{discussion}/replies', 'store');
        Route::delete('/discussions/{discussion}/replies/{reply}', 'destroy');
    });

    Route::controller(InteractiveController::class)->group(function () {
        Route::get('/interactives/{program}', 'show');
        Route::post('/interactives', 'store');
        Route::delete('/interactives/{interactive}', 'destroy');
    });

    Route::controller(UserProgressController::class)->group(function () {
        Route::get('/userProgresses/programs/{program}', 'show');
        Route::post('/userProgresses/programs/{program}/courses/{course}/materials/{material}', 'store');
        Route::get('/userProgresses/programs/{program}/courses/{course}/materials/{material}', 'check');
    });

    Route::controller(MentorController::class)->group(function () {
        Route::post('/mentors', 'store');
        Route::post('/mentors/{mentor}', 'update');
        Route::delete('/mentors/{mentor}', 'destroy');
    });

    Route::controller(ScholarshipController::class)->group(function () {
        Route::post('/scholarships', 'store');
        Route::post('/scholarships/{scholarship}', 'update');
        Route::delete('/scholarships/{scholarship}', 'destroy');
    });

    Route::controller(ArticleController::class)->group(function () {
        Route::post('/articles', 'store');
        Route::post('/articles/{article}', 'update');
        Route::delete('/articles/{article}', 'destroy');
    });

    Route::controller(DiscussionController::class)->group(function () {
        Route::post('/discussions', 'store');
        Route::delete('/discussions/{discussion}', 'destroy');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'show');
        Route::post('/users', 'update');
        Route::delete('/users', 'destroy');
    });

    Route::controller(TagCountryController::class)->group(function () {
        Route::post('/tagCountries', 'store');
        Route::put('/tagCountries/{tagCountry}', 'update');
        Route::delete('/tagCountries/{tagCountry}', 'destroy');
    });

    Route::controller(ProgramController::class)->group(function () {
        Route::post('/programs', 'store');
        Route::post('/programs/{program}', 'update');
        Route::delete('/programs/{program}', 'destroy');
        Route::post('/programs/{program}/buy', 'buy');
    });

    Route::controller(MaterialController::class)->group(function () {
        Route::get('/courses/{course}/materials', 'index');
        Route::get('/courses/{course}/materials/{material}', 'show');
        Route::post('/courses/{course}/materials', 'store');
        Route::post('/courses/{course}/materials/{material}', 'update');
        Route::delete('/courses/{course}/materials/{material}', 'destroy');
    });

    Route::controller(CourseController::class)->group(function () {
        Route::get('/programs/{program}/courses', 'index');
        Route::get('/programs/{program}/courses/{course}', 'show');
        Route::post('/programs/{program}/courses/{course}', 'attach');
        Route::delete('/programs/{program}/courses/{course}', 'detach');
        Route::post('/courses', 'store');
        Route::put('/courses/{course}', 'update');
        Route::delete('/courses/{course}', 'destroy');
    });

    Route::controller(TransactionController::class)->group(function () {
        Route::get('/users/transactions', 'index');
        Route::get('/users/transactions/{transaction}', 'show');
    });

    Route::controller(UserProgramController::class)->group(function () {
        Route::get('/users/programs', 'index');
        Route::get('/users/programs/{program}', 'show');
        Route::post('/users/programs/{program}', 'attach');
        Route::delete('/users/programs/{program}', 'detach');
    });

    Route::controller(ConsultationController::class)->group(function() {
        Route::get('/consultations/available', 'available');
        Route::post('/consultations', 'store');
        Route::get('/consultations', 'show');
    });
});

Route::get('/tagCountries', [TagCountryController::class, 'index']);

Route::get('/tagLevels', [TagLevelController::class, 'index']);

Route::get('/tagCosts', [TagCostController::class, 'index']);

Route::get('tagArticles/{tagArticle}/articles', [ArticleTagArticleController::class, 'index']);

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::controller(DiscussionController::class)->group(function () {
    Route::get('/discussions', 'index');
    Route::get('/discussions/search', 'search');
    Route::get('/discussions/{discussion}', 'show');
});

Route::controller(ReplyController::class)->group(function () {
    Route::get('/discussions/{discussion}/replies', 'index');
    Route::get('/discussions/{discussion}/replies/{reply}', 'show');
});

Route::controller(ArticleController::class)->group(function () {
    Route::get('/articles', 'index');
    Route::get('/articles/{article}', 'show');
    Route::get('/articles/{article}/recomend', 'recomend');
    Route::get('/articles/tagArticles/{tagArticle}', 'filterByTag');
});

Route::controller(MentorController::class)->group(function () {
    Route::get('/mentors', 'index');
    Route::get('/mentors/new', 'showNew');
    Route::get('/mentors/{mentor}', 'show');
});

Route::controller(ProgramController::class)->group(function () {
    Route::get('/programs', 'index');
    Route::get('/programs/new', 'showNew');
    Route::get('/programs/search', 'searchByName');
    Route::get('/programs/filter', 'filterByTag');
    Route::get('/programs/{program}', 'show');
    Route::post('/midtrans/notif-hook');
});

Route::controller(ScholarshipController::class)->group(function () {
    Route::get('/scholarships', 'index');
    Route::get('/scholarships/new', 'showNew');
    Route::get('/scholarships/filter', 'filterByTag');
    Route::get('/scholarships/search', 'searchByName');
    Route::get('/scholarships/{scholarship}', 'show');
});
