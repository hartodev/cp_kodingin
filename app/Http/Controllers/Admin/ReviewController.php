<?php

namespace App\Http\Controllers\Admin;

// php artisan make:controller Admin/ReviewController

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['user', 'course'])
            ->when($request->search, fn($q) => $q->whereHas('user', fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
            ))
            ->when($request->rating, fn($q) => $q->where('rating', $request->rating))
            ->when($request->has('status'), fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    // Route: reviews/{review}
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review berhasil dihapus.');
    }

    // Route: reviews/{review}/toggle
    public function toggle(Review $review)
    {
        $newStatus = ! $review->status;

        $review->update(['status' => $newStatus]);

        $label = $newStatus ? 'ditampilkan' : 'disembunyikan';

        return back()->with('success', "Review berhasil {$label}.");
    }
}