<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
  
    public function index()
    {
        return view('admin.auth.forgot-password');
    }
 
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink($request->only('email'));
 
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Link reset password sudah dikirim ke email kamu.')
            : back()->withErrors(['email' => __($status)]);
    }
}