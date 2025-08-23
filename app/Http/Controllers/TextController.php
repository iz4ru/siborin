<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Text;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TextController extends Controller
{
    public function index()
    {
        $x['texts'] = Text::all();
        return view('admin.contents.text-management.index', $x);
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
        $x['text'] = Text::latest()->get();
        return view('admin.dashboard', $x);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'text' => 'required|string|max:10000',
            ],
            [
                'text.required' => 'Text is required',
                'text.string' => 'Text must be a string',
                'text.max' => 'Text must not exceed 10,000 characters',
            ],
        );

        $title = trim($request->input('title'));
        
        if ($title === '' || $title === null) {
            $title = Str::title(Str::words(trim($request->input('text')), 3, ''));
        }
        if ($title === '') {
            $title = 'Untitled';
        }

        Text::create([
            'user_id' => Auth::id(),
            'title' => $title,
            'text' => $request->input('text'),
        ]);

        $action = 'Submitted ' . strlen($request->input('text')) . ' characters of text';
        $this->log($action);

        return redirect()->route('dashboard')->with('success', 'Text submitted successfully');
    }
}
