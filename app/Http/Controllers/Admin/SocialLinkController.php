<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
   public function index()
    {
        $socialLinks = SocialLink::orderBy('order')->get();

        return view('admin.social-links.index', compact('socialLinks'));
    }

    public function create()
    {
        return view('admin.social-links.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:100',
            'icon'     => 'nullable|string|max:100',
            'url'      => 'required|url',
            'status'   => 'boolean',
        ]);

        SocialLink::create([
            'platform' => $request->platform,
            'icon'     => $request->icon,
            'url'      => $request->url,
            'order'    => SocialLink::max('order') + 1,
            'status'   => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Social link berhasil ditambahkan.');
    }

    public function edit(SocialLink $socialLink)
    {
        return view('admin.social-links.edit', compact('socialLink'));
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $request->validate([
            'platform' => 'required|string|max:100',
            'icon'     => 'nullable|string|max:100',
            'url'      => 'required|url',
            'status'   => 'boolean',
        ]);

        $socialLink->update([
            'platform' => $request->platform,
            'icon'     => $request->icon,
            'url'      => $request->url,
            'status'   => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Social link berhasil diperbarui.');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return back()->with('success', 'Social link berhasil dihapus.');
    }
}
