<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember');

        \Log::info('Remember checked:', ['remember' => $remember]);


        if (Auth::attempt(['name' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
            'login' => 'Username atau password salah.'
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user

        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Buat token baru untuk keamanan

        // Optional: hapus cookie remember (kalau mau benar-benar clean)
        \Cookie::queue(\Cookie::forget('remember_web_' . sha1(config('app.key'))));

        return redirect('/')
            ->with('status', 'Anda telah logout.')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
    }
}
