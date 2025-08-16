<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('guest')->group(function (){
    Route::get('log-in', [AuthController::class, 'index'])->name('login');
    Route::post('log-in', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function (){

    # Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    

    # Logout
    Route::post('log-out', [AuthController::class, 'logout'])->name('logout');
});