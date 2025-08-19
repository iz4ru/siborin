<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TextController extends Controller
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
        $x['text'] = Text::latest()->get();
        return view('admin.dashboard', $x);
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);
        Text::create([
            'user_id' => auth()->id(), // pastikan user login
            'text' => $request->input('text'),
        ]);
        $action = 'Uploaded ' . count($request->input('text')) . ' text(s)';
        $this->log($action);

        return redirect()->route('dashboard')->with('success', 'texts uploaded successfully');
    }
}
