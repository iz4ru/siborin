<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $x['logs'] = Log::all();

        return view('admin.contents.log.index', $x);
    }
}
