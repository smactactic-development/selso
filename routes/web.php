<?php

use Illuminate\Support\Facades\Route;
use Smactactic\Selso\Http\Controllers\Auth\AuthController;
use Smactactic\Selso\Http\Controllers\Settings\ProfileController;

Route::group([
    'middleware' => ['web'],
], function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
        Route::get('/auth/callback', [AuthController::class, 'callback'])->name('auth.callback');
    });

    Route::middleware('jwt.auth')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile');
    });
});
