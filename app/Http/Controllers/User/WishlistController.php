<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/WishlistController

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    // GET /dashboard/wishlist
    public function index()
    {
        $wishlists = Wishlist::with(['course.category', 'course.level'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('user.wishlist', compact('wishlists'));
    }

    // POST /dashboard/wishlist/toggle/{course}
    public function toggle(Course $course)
    {
        $user     = auth()->user();
        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $added   = false;
            $message = 'Kursus dihapus dari wishlist.';
        } else {
            Wishlist::create(['user_id' => $user->id, 'course_id' => $course->id]);
            $added   = true;
            $message = 'Kursus ditambahkan ke wishlist.';
        }

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'added' => $added, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
