<?php

namespace App\Http\Controllers\Auth;

// php artisan make:controller Auth/LoginController

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // GET /auth/login
    public function index()
    {
        return view('auth.login');
    }

    // POST /auth/login
    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput($request->only('email'));
        }

        // Kalau ternyata admin, arahkan ke admin panel
        if (Auth::user()->role === 'admin') {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('user.dashboard'))
            ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
    }

    // POST /dashboard/logout
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')
            ->with('success', 'Berhasil logout. Sampai jumpa!');
    }
}
