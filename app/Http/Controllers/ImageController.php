<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $x['images'] = Image::all();
        return view('admin.contents.image-management.index', $x);
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
        $x['image'] = Image::latest()->get();
        return view('admin.dashboard', $x);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                Storage::disk('supabase')->putFileAs('', $file, $filename);
                $url = env('SUPABASE_VIEW') . env('SUPABASE_BUCKET') . "/" . $filename;

                Image::create([
                    'user_id' => Auth::id(),
                    'filename' => $file->getClientOriginalName(),
                    'path' => $url,
                ]);
            }

            $action = 'Uploaded ' . count($request->file('image')) . ' image(s)';
            $this->log($action);

            return redirect()->route('dashboard')->with('success', 'Images uploaded successfully');
        }

        if ($request->has('image_url')) {
            $validatedData = $request->validate(
                [
                    'image_url' => 'required|url|unique:images,image_url',
                ],
                [
                    'image_url.required' => 'Image URL is required',
                    'image_url.url' => 'Please provide a valid URL',
                    'image_url.unique' => 'This image URL has already been added',
                ],
            );

            Image::create([
                'user_id' => Auth::id(),
                'image_url' => $validatedData['image_url'],
            ]);

            $action = 'Added image from URL: ' . $validatedData['image_url'];
            $this->log($action);

            return redirect()->route('dashboard')->with('success', 'Image URL added successfully');
        }

        return redirect()->route('dashboard')->withErrors('No image or URL provided');
    }
}
