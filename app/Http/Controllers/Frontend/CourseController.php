<?php

namespace App\Http\Controllers\Frontend;

// php artisan make:controller Frontend/CourseController

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\Tag;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with(['category', 'level'])
            ->where('status', 'active')
            ->withCount(['enrollments' => fn($q) => $q->where('have_access', true)])
            ->withAvg('reviews', 'rating')
            ->when(
                $request->search,
                fn($q) =>
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%")
            )
            ->when(
                $request->category,
                fn($q) =>
                $q->whereHas('category', fn($q) => $q->where('slug', $request->category))
            )
            ->when(
                $request->level,
                fn($q) =>
                $q->whereHas('level', fn($q) => $q->where('slug', $request->level))
            )
            ->when(
                $request->tag,
                fn($q) =>
                $q->whereHas('tags', fn($q) => $q->where('slug', $request->tag))
            )
            ->when(
                $request->sort === 'popular',
                fn($q) =>
                $q->orderByDesc('enrollments_count')
            )
            ->when(
                $request->sort === 'rating',
                fn($q) =>
                $q->orderByDesc('reviews_avg_rating')
            )
            ->when(!$request->sort, fn($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        $categories = CourseCategory::active()
            ->withCount(['courses' => fn($q) => $q->where('status', 'active')])
            ->get();

        $levels = CourseLevel::withCount(['courses' => fn($q) => $q->where('status', 'active')])->get();
        $tags   = Tag::withCount(['courses' => fn($q) => $q->where('status', 'active')])->get();

        return view('frontend.courses.index', compact('courses', 'categories', 'levels', 'tags'));
    }

    // Route: /courses/{slug}
    public function show(string $slug)
    {
        $course = Course::with([
            'category',
            'level',
            'tags',
            'chapters' => fn($q) => $q->where('status', true)->orderBy('order'),
            'chapters.lessons' => fn($q) => $q->where('status', true)->orderBy('order'),
            'reviews.user',
        ])
            ->withCount(['enrollments' => fn($q) => $q->where('have_access', true)])
            ->withAvg('reviews', 'rating')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Cek status user terhadap kursus ini
        $isEnrolled   = auth()->check() && auth()->user()->isEnrolled($course->id);
        $isInCart     = auth()->check() && auth()->user()->isInCart($course->id);
        $isWishlisted = auth()->check() && auth()->user()->isWishlisted($course->id);

        // Review user yang login
        $userReview = null;
        if (auth()->check()) {
            $userReview = $course->reviews->firstWhere('user_id', auth()->id());
        }

        // Kursus terkait
        $relatedCourses = Course::with(['category'])
            ->where('status', 'active')
            ->where('id', '!=', $course->id)
            ->where('category_id', $course->category_id)
            ->withCount(['enrollments' => fn($q) => $q->where('have_access', true)])
            ->withAvg('reviews', 'rating')
            ->limit(4)
            ->get();

        // Total lesson & durasi
        $totalLessons  = $course->chapters->flatMap->lessons->count();
        $previewLessons = $course->chapters->flatMap->lessons->where('is_preview', true);

        return view('frontend.courses.show', compact(
            'course',
            'isEnrolled',
            'isInCart',
            'isWishlisted',
            'userReview',
            'relatedCourses',
            'totalLessons',
            'previewLessons'
        ));
    }
}
