<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
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
        $x['video'] = Video::latest()->get();
        return view('admin.dashboard', $x);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('video')) {
            foreach ($request->file('video') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                Storage::disk('supabase')->putFileAs('', $file, $filename);
                $url = env('SUPABASE_VIEW') . env('SUPABASE_BUCKET') . "/" . $filename;

                Image::create([
                    'user_id' => auth()->id(), // pastikan user login
                    'filename' => $file->getClientOriginalName(),
                    'path' => $url,
                ]);
            }

            $action = 'Uploaded ' . count($request->file('video')) . ' video(s)';
            $this->log($action);

            return redirect()->route('dashboard')->with('success', 'Videos uploaded successfully');
        }

        if ($request->has('video_url')) {
            $validatedData = $request->validate(
                [
                    'video_url' => 'required|url|unique:videos,video_url',
                ],
                [
                    'video_url.required' => 'Video URL is required',
                    'video_url.url' => 'Please provide a valid URL',
                    'video_url.unique' => 'This video URL has already been added',
                ],
            );

            Image::create([
                'user_id' => auth()->id(),
                'video_url' => $validatedData['video_url'],
            ]);

            $action = 'Added video from URL: ' . $validatedData['video_url'];
            $this->log($action);

            return redirect()->route('dashboard')->with('success', 'Video URL added successfully');
        }

        return redirect()->route('dashboard')->withErrors('No video or URL provided');
    }
}
