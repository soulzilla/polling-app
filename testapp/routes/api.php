<?php

use App\Http\Controllers\v1\AnswersController;
use App\Http\Controllers\v1\PassportAuthController;
use App\Http\Controllers\v1\QuestionsController;
use App\Http\Controllers\v1\SurveysController;
use App\Http\Controllers\v1\VariantsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('register', [PassportAuthController::class, 'register'])->name('register');
    Route::post('login', [PassportAuthController::class, 'login'])->name('login');

    Route::middleware('auth:api')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::get('/surveys', [SurveysController::class, 'index'])->name('surveys.index');
        Route::get('/surveys/{survey}', [SurveysController::class, 'show'])->name('surveys.show');
        Route::post('/surveys', [SurveysController::class, 'store'])->name('surveys.store');
        Route::patch('/surveys/{survey}', [SurveysController::class, 'update'])->name('surveys.update');
        Route::delete('/surveys/{survey}', [SurveysController::class, 'delete'])->name('surveys.delete');

        Route::get('/questions', [QuestionsController::class, 'index'])->name('questions.index');
        Route::get('/questions/{question}', [QuestionsController::class, 'show'])->name('questions.show');
        Route::post('/questions', [QuestionsController::class, 'store'])->name('questions.store');
        Route::patch('/questions/{question}', [QuestionsController::class, 'update'])->name('questions.update');
        Route::delete('/questions/{question}', [QuestionsController::class, 'delete'])->name('questions.delete');

        Route::get('/variants', [VariantsController::class, 'index'])->name('variants.index');
        Route::get('/variants/{variant}', [VariantsController::class, 'show'])->name('variants.show');
        Route::post('/variants', [VariantsController::class, 'store'])->name('variants.store');
        Route::patch('/variants/{variant}', [VariantsController::class, 'update'])->name('variants.update');
        Route::delete('/variants/{variant}', [VariantsController::class, 'delete'])->name('variants.delete');

        Route::post('/answers', [AnswersController::class, 'store'])->name('answers.store');
        Route::patch('/answers/{answer}', [AnswersController::class, 'update'])->name('answers.update');
        Route::delete('/answers/{answer}', [AnswersController::class, 'delete'])->name('answers.delete');
    });
});
