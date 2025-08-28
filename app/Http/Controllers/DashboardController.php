<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $options = Option::firstOrCreate(
            ['user_id' => Auth::id()],
            ['show_images' => true, 'show_videos' => true, 'show_musics' => true]
        );

        return view('admin.dashboard', compact('options'));
    }

    public function optionsForm() {
        $options = Option::firstOrCreate(['user_id' => Auth::id()]);
        return view('dashboard.options', compact('options'));
    }

    public function saveOptions(Request $request) {
        $options = Option::firstOrCreate(['user_id' => Auth::id()]);
        $options->update([
            'show_images' => $request->has('show_images'),
            'show_videos' => $request->has('show_videos'),
            'show_musics' => $request->has('show_musics'),
        ]);
        return redirect()->back()->with('success', 'Pilihan berhasil disimpan!');
    }
}
