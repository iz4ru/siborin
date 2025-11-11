<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GuestController extends Controller
{
    public function index()
    {
        return view('guest.form');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'agency' => 'required|string|max:255',
                'photo_data' => 'required|string',
            ],
            [
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.max' => 'Nama lengkap maksimal 255 karakter.',
                'agency.required' => 'Asal instansi wajib diisi.',
                'agency.max' => 'Asal instansi maksimal 255 karakter.',
                'photo_data.required' => 'Foto wajib diambil.',
            ],
        );

        // Decode base64 image
        $photoData = str_replace('data:image/jpeg;base64,', '', $request->photo_data);
        $photoData = str_replace(' ', '+', $photoData);
        $imageContent = base64_decode($photoData);

        // Generate filename & temp file
        $filename = 'guest_' . $validated['name'] . '_' . time() . '_' . uniqid() . '.jpg';
        $tempPath = sys_get_temp_dir() . '/' . $filename;
        file_put_contents($tempPath, $imageContent);

        // Upload to Supabase
        $uploadedFile = new UploadedFile($tempPath, $filename, 'image/jpeg', null, true);
        Storage::disk('supabase_guest')->putFileAs('', $uploadedFile, $filename);
        $url = env('SUPABASE_VIEW') . env('SUPABASE_BUCKET_GUEST') . '/' . $filename;

        // Cleanup
        if (file_exists($tempPath)) {
            unlink($tempPath);
        }

        // Save to database
        Guest::create([
            'name' => $validated['name'],
            'agency' => $validated['agency'],
            'photo' => $url,
        ]);

        // Redirect ke halaman thanks dengan data tamu
        return redirect()
            ->route('guest.thanks')
            ->with([
                'guest_name' => $validated['name'],
                'guest_agency' => $validated['agency'],
            ]);
    }

    public function thanks()
    {
        return view('guest.thanks');
    }
}
