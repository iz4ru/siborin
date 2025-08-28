<?php

use App\Models\Image;
use App\Models\Music;
use App\Models\Video;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TextController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('display', [DisplayController::class, 'index'])->name('display.index');
Route::get('display/check', [DisplayController::class, 'check'])->name('display.check');
Route::get('display/data', [DisplayController::class, 'data'])->name('display.data');

Route::middleware('guest')->group(function (){
    Route::get('log-in', [AuthController::class, 'index'])->name('login');
    Route::post('log-in', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function (){

    # Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/options', [DashboardController::class, 'optionsForm'])->name('dashboard.options');
    Route::post('dashboard/options', [DashboardController::class, 'saveOptions'])->name('dashboard.options.store');


    # Images
    Route::get('image', [ImageController::class, 'index'])->name('image.index');
    Route::get('image-upload', [ImageController::class, 'upload'])->name('image.upload');
    Route::post('image-store', [ImageController::class, 'store'])->name('image.store');
    Route::delete('image-delete/{id}', [ImageController::class, 'destroy'])->name('image.destroy');

    # Videos
    Route::get('video', [VideoController::class, 'index'])->name('video.index');
    Route::get('video-upload', [VideoController::class, 'upload'])->name('video.upload');
    Route::post('video-store', [VideoController::class, 'store'])->name('video.store');

    # Music
    Route::get('music', [MusicController::class, 'index'])->name('music.index');
    Route::get('music-upload', [MusicController::class, 'upload'])->name('music.upload');
    Route::post('music-store', [MusicController::class, 'store'])->name('music.store');

    # Text
    Route::get('text', [TextController::class, 'index'])->name('text.index');
    Route::get('text-upload', [TextController::class, 'upload'])->name('text.upload');
    Route::post('text-store', [TextController::class, 'store'])->name('text.store');

    # Logs
    Route::get('logs', [LogController::class, 'index'])->name('logs');

    # Logout
    Route::post('log-out', [AuthController::class, 'logout'])->name('logout');
});
