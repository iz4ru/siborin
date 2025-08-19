<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MusicController extends Controller
{
    public function log($action)
    {
        $user = Auth::user();
        $username = $user->username;

        $log = new Log([
            'username' => $username,
            'action' => $action,
            'ip_address' => request()->ip(),
        ]);

        $log->save();
    }

    public function upload()
    {
        $x['music'] = Music::latest()->get();
        return view('admin.dashboard', $x);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('music')) {
            foreach ($request->file('music') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                Storage::disk('supabase')->putFileAs('', $file, $filename);
                $url = env('SUPABASE_VIEW') . env('SUPABASE_BUCKET') . "/" . $filename;

                Music::create([
                    'user_id' => auth()->id(), // pastikan user login
                    'filename' => $file->getClientOriginalName(),
                    'path' => $url,
                ]);
            }

            $action = 'Uploaded ' . count($request->file('music')) . ' music(s)';
            $this->log($action);

            return redirect()->route('dashboard')->with('success', 'musics uploaded successfully');
        }

        if ($request->has('music_url')) {
            $validatedData = $request->validate(
                [
                    'music_url' => 'required|url|unique:musics,music_url',
                ],
                [
                    'music_url.required' => 'music URL is required',
                    'music_url.url' => 'Please provide a valid URL',
                    'music_url.unique' => 'This music URL has already been added',
                ],
            );

            music::create([
                'user_id' => auth()->id(),
                'music_url' => $validatedData['music_url'],
            ]);

            $action = 'Added music from URL: ' . $validatedData['music_url'];
            $this->log($action);

            return redirect()->route('dashboard')->with('success', 'music URL added successfully');
        }

        return redirect()->route('dashboard')->withErrors('No music or URL provided');
    }
}
