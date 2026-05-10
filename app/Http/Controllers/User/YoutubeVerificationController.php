<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/YoutubeVerificationController

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Models\YoutubeVerification;
use Illuminate\Http\Request;

class YoutubeVerificationController extends Controller
{
    // GET /dashboard/verification/{order}/status
    public function status(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.course', 'youtubeVerification']);

        $youtubeChannelUrl  = Setting::get('youtube_channel_url');
        $youtubeChannelName = Setting::get('youtube_channel_name');

        return view('user.verification-status', compact(
            'order',
            'youtubeChannelUrl',
            'youtubeChannelName'
        ));
    }

    // POST /dashboard/verification/{order}/submit
    public function submit(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order ini sudah diproses sebelumnya.');
        }

        // Cek apakah sudah ada verifikasi pending
        if ($order->youtubeVerification && $order->youtubeVerification->status === 'pending') {
            return back()->with('error', 'Kamu sudah mengirim bukti verifikasi. Tunggu review dari admin.');
        }

        $request->validate([
            'youtube_channel_name' => 'required|string|max:255',
            'youtube_channel_url'  => 'required|url|max:255',
            'proof_image'          => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'youtube_channel_name.required' => 'Nama channel YouTube wajib diisi.',
            'youtube_channel_url.required'  => 'URL channel YouTube wajib diisi.',
            'youtube_channel_url.url'       => 'URL channel YouTube tidak valid.',
            'proof_image.required'          => 'Screenshot bukti subscribe wajib diupload.',
            'proof_image.image'             => 'File harus berupa gambar.',
            'proof_image.max'               => 'Ukuran gambar maksimal 3MB.',
        ]);

        $proofImage = $request->file('proof_image')->store('verifications', 'public');

        YoutubeVerification::create([
            'user_id'              => auth()->id(),
            'order_id'             => $order->id,
            'youtube_channel_name' => $request->youtube_channel_name,
            'youtube_channel_url'  => $request->youtube_channel_url,
            'proof_image'          => $proofImage,
            'status'               => 'pending',
        ]);

        $order->update(['status' => 'waiting_verification']);

        return redirect()->route('user.verification.status', $order)
            ->with('success', 'Bukti verifikasi berhasil dikirim! Admin akan mereview dalam 1x24 jam.');
    }
}
