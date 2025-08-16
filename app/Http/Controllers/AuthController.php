<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ],
            [
                'email.required' => 'Email is required.',
                'email.email' => 'Please provide a valid email address.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters long.',
            ],
        );

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()
                ->intended('dashboard')
                ->with('success', 'Login success, welcome back ' . Auth::user()->name . ' !');
        }

        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
