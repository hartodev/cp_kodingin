<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\YoutubeVerification;
use Illuminate\Http\Request;

class YoutubeVerificationController extends Controller
{

    public function index(Request $request)
    {
        $verifications = YoutubeVerification::with(['user', 'order.items.course'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->whereHas('user', fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
            ))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $pendingCount = YoutubeVerification::where('status', 'pending')->count();

        return view('admin.verifications.index', compact('verifications', 'pendingCount'));
    }

    public function show(YoutubeVerification $verification)
    {
        $verification->load(['user', 'order.items.course', 'verifiedBy']);

        return view('admin.verifications.show', compact('verification'));
    }

    // ── Approve verifikasi → buka akses kursus otomatis ───────────
    public function approve(Request $request, YoutubeVerification $verification)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        if ($verification->status !== 'pending') {
            return back()->with('error', 'Verifikasi ini sudah diproses sebelumnya.');
        }

        $verification->approve(auth()->id(), $request->admin_note);

        return back()->with('success', 'Verifikasi disetujui. Akses kursus sudah dibuka untuk user.');
    }

    // ── Reject verifikasi ──────────────────────────────────────────
    public function reject(Request $request, YoutubeVerification $verification)
    {
        $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        if ($verification->status !== 'pending') {
            return back()->with('error', 'Verifikasi ini sudah diproses sebelumnya.');
        }

        $verification->reject(auth()->id(), $request->admin_note);

        return back()->with('success', 'Verifikasi ditolak. Notifikasi sudah dikirim ke user.');
    }
}
