<?php

use Illuminate\Support\Facades\Route;
use Smactactic\Selso\Http\Controllers\Auth\AuthController;
use Smactactic\Selso\Http\Controllers\Settings\ProfileController;

Route::group([
    'middleware' => ['web'],
], function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('selso.login');
        Route::get('/auth/callback', [AuthController::class, 'callback'])->name('selso.callback');
    });

    Route::middleware('selso.auth')->group(function () {
        Route::get('/logout', [AuthController::class, 'destroy'])->name('selso.logout');
        Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile');
    });
});
