<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/DashboardController

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Notification;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Enrollment aktif terbaru
        $enrollments = Enrollment::with(['course.category'])
            ->where('user_id', $user->id)
            ->where('have_access', true)
            ->latest()
            ->limit(4)
            ->get();

        // Order yang belum selesai (pending / waiting_verification)
        $pendingOrders = Order::with(['items.course', 'youtubeVerification'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'waiting_verification'])
            ->latest()
            ->get();

        // Notifikasi belum dibaca
        $unreadNotifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->latest()
            ->limit(5)
            ->get();

        // Stats
        $stats = [
            'total_courses'    => Enrollment::where('user_id', $user->id)->where('have_access', true)->count(),
            'total_orders'     => Order::where('user_id', $user->id)->count(),
            'unread_notif'     => Notification::where('user_id', $user->id)->where('is_read', false)->count(),
            'total_cert'       => \App\Models\Certificate::where('user_id', $user->id)->count(),
        ];

        return view('user.dashboard', compact(
            'enrollments',
            'pendingOrders',
            'unreadNotifications',
            'stats'
        ));
    }
}
