<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\MessageController;

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

Route::group(['prefix' => 'v1', 'middleware' => 'api'], function () {
    // REGISTER AND LOGIN
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [LoginController::class, 'login']);
        Route::post('logout', [LoginController::class, 'logout']);
        Route::post('refresh', [LoginController::class, 'refresh']);
        Route::post('register', [RegisterController::class, 'register']);
    });
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('groups/unsubscribe', [GroupController::class, 'unSubscribe']);
        Route::post('groups/subscribe', [GroupController::class, 'subscribe']);
        Route::get('groups/search', [GroupController::class, 'searchGroup']);
        Route::apiResource('groups', GroupController::class);
        Route::apiResource('groups.events', EventController::class)->shallow();
        Route::apiResource('groups.questions', QuestionController::class)->shallow();
        Route::apiResource('groups.chats', ChatController::class)->shallow();
        Route::apiResource('chats.messages', MessageController::class)->shallow()->except(['show']);
        Route::apiResource('questions.answers', AnswerController::class)->shallow();
    });
});
