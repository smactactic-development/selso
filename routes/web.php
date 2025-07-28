<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/auth/callback', [AuthController::class, 'callback'])->name('auth.callback');
});

Route::middleware('jwt.auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile');
});
