<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);

Route::post('reset-password', [AuthController::class, 'sendResetPasswordEmail'])->name('password.reset');

Route::post('set-password', [AuthController::class, 'setNewPassword']);



Route::middleware('auth:api')->group(function () {
    Route::post('/users/{user}', [UserController::class, 'updateUserData']);

    Route::get('/users', [UserController::class, 'index']);

    Route::get('/users/{user}', [UserController::class, 'view']);

    Route::delete('/users/{user}', [UserController::class, 'delete']);
});
