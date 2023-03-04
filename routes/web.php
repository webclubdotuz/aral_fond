<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PersonalController;
use Illuminate\Support\Facades\Route;

// Login

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

Route::group(['middleware' => 'auth'], function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Admin
    Route::group(['middleware' => 'role:admin'], function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::resource('roles', \App\Http\Controllers\RoleController::class);

        Route::get('/personals', [PersonalController::class, 'index'])->name('personals.index');


        Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    });


});

// Telegram webhook
Route::any('/bot', [\App\Http\Controllers\TelegramController::class, 'index'])->name('bot');
