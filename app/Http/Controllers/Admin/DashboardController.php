<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use App\Models\YoutubeVerification;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'       => User::where('role', 'user')->count(),
            'total_courses'     => Course::count(),
            'total_enrollments' => Enrollment::where('have_access', true)->count(),
            'total_orders'      => Order::count(),
            'pending_verif'     => YoutubeVerification::where('status', 'pending')->count(),
            'unread_contacts'   => Contact::where('is_read', false)->count(),
            'total_reviews'     => Review::where('status', true)->count(),
        ];

        // Order terbaru
        $latestOrders = Order::with(['user', 'items.course'])
            ->latest()
            ->limit(5)
            ->get();

        // Verifikasi YouTube menunggu
        $pendingVerifications = YoutubeVerification::with(['user', 'order'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        // Kursus terpopuler
        $popularCourses = Course::withCount(['enrollments' => fn($q) => $q->where('have_access', true)])
            ->orderByDesc('enrollments_count')
            ->limit(5)
            ->get();

        // User terbaru
        $latestUsers = User::where('role', 'user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'latestOrders',
            'pendingVerifications',
            'popularCourses',
            'latestUsers'
        ));
    }
}
