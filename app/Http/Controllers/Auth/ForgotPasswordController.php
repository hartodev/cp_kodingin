<?php

namespace App\Http\Controllers\Auth;

// php artisan make:controller Auth/ForgotPasswordController

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // GET /auth/forgot-password
    public function index()
    {
        return view('auth.forgot-password');
    }

    // POST /auth/forgot-password
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Link reset password sudah dikirim ke email kamu. Cek inbox atau folder spam.')
            : back()->withErrors(['email' => __($status)])->withInput();
    }
}
