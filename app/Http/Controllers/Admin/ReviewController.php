<?php

namespace App\Http\Controllers\Admin;

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
            ->when(isset($request->status), fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review berhasil dihapus.');
    }

    // ── Toggle status review (tampil/sembunyikan) ──────────────────
    public function toggle(Review $review)
    {
        $review->update(['status' => ! $review->status]);

        $status = $review->status ? 'ditampilkan' : 'disembunyikan';

        return back()->with('success', "Review berhasil {$status}.");
    }
}
