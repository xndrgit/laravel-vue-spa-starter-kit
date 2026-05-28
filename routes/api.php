<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\UserAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest', 'throttle:5,1'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['guest', 'throttle:3,1'])->group(function () {
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
    Route::post('/reset-password', [PasswordResetController::class, 'reset']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::patch('/user/profile', [UserAccountController::class, 'updateProfile'])->middleware('throttle:10,1');
    Route::patch('/user/email', [UserAccountController::class, 'updateEmail'])->middleware('throttle:6,1');
    Route::put('/user/password', [UserAccountController::class, 'updatePassword'])->middleware('throttle:6,1');
});
