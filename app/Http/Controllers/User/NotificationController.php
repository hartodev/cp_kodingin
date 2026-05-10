<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/NotificationController

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    // GET /dashboard/notifications
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        // Tandai semua sebagai dibaca saat halaman dibuka
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('user.notifications', compact('notifications'));
    }

    // POST /dashboard/notifications/{notification}/read
    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        if ($notification->url) {
            return redirect($notification->url);
        }

        return back();
    }

    // POST /dashboard/notifications/read-all
    public function readAll()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
