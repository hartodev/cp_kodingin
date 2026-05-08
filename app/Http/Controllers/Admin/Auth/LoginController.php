<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ── Tampilkan halaman login admin ──────────────────────────────
    public function index()
    {
        return view('admin.auth.login');
    }

    // ── Proses login admin ─────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        // Pastikan yang login memang admin
        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return back()->withErrors(['email' => 'Akses ditolak. Kamu bukan admin.'])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
    }

    // ── Logout admin ───────────────────────────────────────────────
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Berhasil logout.');
    }
}
