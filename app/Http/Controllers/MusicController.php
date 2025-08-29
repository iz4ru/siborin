<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MusicController extends Controller
{
    public function index()
    {
        $x['songs'] = Music::all();
        return view('admin.contents.music-management.index', $x);
    }

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
                $extension = $file->extension();
                $filename = time() . '_' . Str::random(10) . '.' . $extension;
                Storage::disk('supabase')->putFileAs('', $file, $filename);
                $url = env('SUPABASE_VIEW') . env('SUPABASE_BUCKET') . "/" . $filename;

                Music::create([
                    'user_id' => Auth::id(), // pastikan user login
                    'filename' => $file->getClientOriginalName(),
                    'path' => $url,
                ]);
            }

            $action = 'Uploaded ' . count($request->file('music')) . ' music(s)';
            $this->log($action);

            return redirect()->route('dashboard')->with('success', 'music uploaded successfully');
        }

        if ($request->has('music_url')) {
            $validatedData = $request->validate(
                [
                    'music_url' => 'required|url|unique:music,music_url',
                ],
                [
                    'music_url.required' => 'music URL is required',
                    'music_url.url' => 'Please provide a valid URL',
                    'music_url.unique' => 'This music URL has already been added',
                ],
            );

            Music::create([
                'user_id' => Auth::id(),
                'music_url' => $validatedData['music_url'],
            ]);

            $action = 'Added music from URL: ' . $validatedData['music_url'];
            $this->log($action);

            return redirect()->route('dashboard')->with('success', 'Music URL added successfully');
        }

        return redirect()->route('dashboard')->withErrors('No music or URL provided');
    }

        public function destroy($id)
    {
        $music = Music::findOrFail($id);

        if ($music->user_id !== Auth::id()) {
            return back()->withErrors('Unauthorized action');
        }

        if ($music->path && !filter_var($music->path, FILTER_VALIDATE_URL)) {
            $filename = basename($music->path);
            Storage::disk('supabase')->delete($filename);
        }

        $music->delete();

        $action = 'Deleted music: ' . ($music->filename ?? $music->music_url);
        $this->log($action);

        return back()->with('success', 'Music deleted successfully');
    }
}
