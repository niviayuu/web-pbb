<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Password reset fallback routes
Route::get('forgot-password', [AuthController::class, 'showLogin'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'showLogin'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showLogin'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'showLogin'])->name('password.update');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');
