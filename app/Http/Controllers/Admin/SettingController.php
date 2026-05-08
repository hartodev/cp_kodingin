<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
     public function index()
    {
        // Ambil semua settings dan jadikan key => value array
        $settings = Setting::all()->pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'           => 'required|string|max:100',
            'site_email'          => 'required|email',
            'site_phone'          => 'nullable|string|max:20',
            'site_address'        => 'nullable|string|max:255',
            'site_description'    => 'nullable|string|max:500',
            'youtube_channel_url' => 'nullable|url',
            'youtube_channel_name'=> 'nullable|string|max:100',
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string|max:255',
            'meta_keywords'       => 'nullable|string|max:255',
            'google_analytics_id' => 'nullable|string|max:50',
            'footer_copyright'    => 'nullable|string|max:255',
            'footer_description'  => 'nullable|string|max:500',
            'site_logo'           => 'nullable|image|mimes:png,jpg,svg|max:1024',
            'site_favicon'        => 'nullable|image|mimes:png,ico|max:512',
        ]);

        // Upload logo
        if ($request->hasFile('site_logo')) {
            Setting::set('site_logo', $request->file('site_logo')->store('settings', 'public'));
        }

        // Upload favicon
        if ($request->hasFile('site_favicon')) {
            Setting::set('site_favicon', $request->file('site_favicon')->store('settings', 'public'));
        }

        // Simpan semua setting teks
        $textKeys = [
            'site_name', 'site_email', 'site_phone', 'site_address', 'site_description',
            'site_tagline', 'youtube_channel_url', 'youtube_channel_name', 'youtube_channel_id',
            'meta_title', 'meta_description', 'meta_keywords', 'google_analytics_id',
            'footer_copyright', 'footer_description',
        ];

        foreach ($textKeys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
