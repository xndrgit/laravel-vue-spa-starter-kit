<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\EmailChangeVerificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::get('/users', [AdminPageController::class, 'users'])->name('users');
        Route::get('/settings', [AdminPageController::class, 'settings'])->name('settings');
        Route::get('/system', [AdminPageController::class, 'system'])->name('system');
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
    });
});

Route::get('/email-change/verify/{user}/{token}', EmailChangeVerificationController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('email-change.verify');

Route::view('/', 'app')->name('spa');

Route::view('/{any}', 'app')
    ->where('any', '^(?!api|admin|storage|sanctum).*$')
    ->name('spa.fallback');
