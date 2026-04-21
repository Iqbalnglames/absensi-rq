<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.Auth.login');
    }

    // 🔹 Proses login
    public function login(Request $request)
    {
        // validasi
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $remember = $request->filled('remember');

        // cek login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return redirect()->back()->withErrors([
            'username' => 'Username atau password salah',
        ])->withInput();
    }

    // 🔹 Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
