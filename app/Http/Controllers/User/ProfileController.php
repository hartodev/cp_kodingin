<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/ProfileController

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // GET /dashboard/profile
    public function index()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    // PUT /dashboard/profile
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'headline'  => 'nullable|string|max:255',
            'bio'       => 'nullable|string|max:1000',
            'gender'    => 'nullable|in:male,female',
            'github'    => 'nullable|url|max:255',
            'linkedin'  => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'facebook'  => 'nullable|url|max:255',
            'x'         => 'nullable|url|max:255',
            'website'   => 'nullable|url|max:255',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'  => 'Email sudah digunakan akun lain.',
        ]);

        $data = $request->except(['image', '_token', '_method']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // PUT /dashboard/profile/password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.min'              => 'Password minimal 8 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        $user = auth()->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai.',
            ]);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
