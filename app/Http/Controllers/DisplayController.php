<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Video;
use App\Models\Music;

class DisplayController extends Controller
{
    public function index()
    {
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

        $items = collect()->merge($images)->merge($videos)->merge($musics);

        return view('monitor.display', compact('items'));
    }

    public function check()
    {
        return response()->json([
            'count' => Image::count() + Video::count() + Music::count(),
            'updated_at' => collect([
                Image::max('updated_at'),
                Video::max('updated_at'),
                Music::max('updated_at'),
            ])->filter()->max(),
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
          ->header('Pragma', 'no-cache')
          ->header('Expires', '0');
    }

    public function data()
    {
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
    }
}