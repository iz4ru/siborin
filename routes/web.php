<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TextController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\VideoController;
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

    # Images
    Route::get('image-upload', [ImageController::class, 'upload'])->name('image.upload');
    Route::post('image-store', [ImageController::class, 'store'])->name('image.store');

    # Videos
    Route::get('video-upload', [VideoController::class, 'upload'])->name('video.upload');
    Route::post('video-store', [VideoController::class, 'store'])->name('video.store');

    # Music
    Route::get('music-upload', [MusicController::class, 'upload'])->name('music.upload');
    Route::post('music-store', [MusicController::class, 'store'])->name('music.store');

    # Text
    Route::get('text-upload', [TextController::class, 'upload'])->name('text.upload');
    Route::post('text-store', [TextController::class, 'store'])->name('text.store');

    # Logout
    Route::post('log-out', [AuthController::class, 'logout'])->name('logout');
});