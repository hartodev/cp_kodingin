<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/ReviewController

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // POST /dashboard/courses/{course}/review
    public function store(Request $request, Course $course)
    {
        $user = auth()->user();

        if (! $user->isEnrolled($course->id)) {
            return back()->with('error', 'Kamu harus enroll kursus ini untuk bisa memberikan review.');
        }

        if (Review::where('user_id', $user->id)->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'Kamu sudah pernah memberikan review untuk kursus ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.min'      => 'Rating minimal 1 bintang.',
            'rating.max'      => 'Rating maksimal 5 bintang.',
            'review.required' => 'Review wajib diisi.',
            'review.min'      => 'Review minimal 10 karakter.',
        ]);

        Review::create([
            'user_id'   => $user->id,
            'course_id' => $course->id,
            'rating'    => $request->rating,
            'review'    => $request->review,
            'status'    => true,
        ]);

        return back()->with('success', 'Review berhasil dikirim. Terima kasih!');
    }

    // PUT /dashboard/courses/{course}/review
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000',
        ]);

        $review = Review::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->firstOrFail();

        $review->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Review berhasil diperbarui.');
    }

    // DELETE /dashboard/courses/{course}/review
    public function destroy(Course $course)
    {
        Review::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->delete();

        return back()->with('success', 'Review berhasil dihapus.');
    }
}
