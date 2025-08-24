<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TextController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DashboardController;
use App\Models\Image;
use App\Models\Video;
use App\Models\Music;

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

    Route::get('display', function () {
        $userId = auth()->id(); // ambil user yang login

        $images = Image::where('user_id', $userId)
            ->select('id', 'filename', 'path', 'image_url', 'created_at')
            ->get()
            ->map(fn($i) => [
                'type' => 'image',
                'id' => $i->id,
                'filename' => $i->filename,
                'src' => $i->path ?: $i->image_url,
                'created_at' => $i->created_at,
            ]);

        $videos = Video::where('user_id', $userId)
            ->select('id', 'filename', 'path', 'video_url', 'created_at')
            ->get()
            ->map(fn($v) => [
                'type' => 'video',
                'id' => $v->id,
                'filename' => $v->filename,
                'src' => $v->path ?: $v->video_url,
                'created_at' => $v->created_at,
            ]);

        $musics = Music::where('user_id', $userId)
            ->select('id', 'filename', 'path', 'music_url', 'created_at')
            ->get()
            ->map(fn($m) => [
                'type' => 'music',
                'id' => $m->id,
                'filename' => $m->filename,
                'src'  => $m->path ?: $m->music_url,
                'created_at' => $m->created_at,
            ]);

        $items = collect()->merge($images)->merge($videos)->merge($musics);

        return view('monitor.display', compact('items'));
    })->name('display.index');

    Route::get('/display/check', function () {
        return response()->json([
            'count' => \App\Models\Image::count()
                    + \App\Models\Video::count()
                    + \App\Models\Music::count(),
            'updated_at' => collect([
                \App\Models\Image::max('updated_at'),
                \App\Models\Video::max('updated_at'),
                \App\Models\Music::max('updated_at'),
            ])->filter()->max(),
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
    })->name('display.check');

    Route::get('display/data', function () {
        $userId = auth()->id();

        $images = Image::where('user_id', $userId)
            ->select('id', 'filename', 'path', 'image_url', 'created_at')
            ->get()
            ->map(fn($i) => [
                'type' => 'image',
                'id' => $i->id,
                'filename' => $i->filename,
                'src' => $i->path ?: $i->image_url,
                'created_at' => $i->created_at,
            ]);

        $videos = Video::where('user_id', $userId)
            ->select('id', 'filename', 'path', 'video_url', 'created_at')
            ->get()
            ->map(fn($v) => [
                'type' => 'video',
                'id' => $v->id,
                'filename' => $v->filename,
                'src' => $v->path ?: $v->video_url,
                'created_at' => $v->created_at,
            ]);

        $musics = Music::where('user_id', $userId)
            ->select('id', 'filename', 'path', 'music_url', 'created_at')
            ->get()
            ->map(fn($m) => [
                'type' => 'music',
                'id' => $m->id,
                'filename' => $m->filename,
                'src'  => $m->path ?: $m->music_url,
                'created_at' => $m->created_at,
            ]);

        $items = collect()->merge($images)->merge($videos)->merge($musics)->values();

        return response()->json($items)
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    })->name('display.data');
});