<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
   public function index()
    {
        return view('admin.auth.login');
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);
 
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }
 
        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return back()->withErrors(['email' => 'Akses ditolak. Kamu bukan admin.'])->withInput();
        }
 
        $request->session()->regenerate();
 
        return redirect()->route('admin.dashboard')
            ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
    }
 
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect()->route('admin.login')->with('success', 'Berhasil logout.');
    }
}