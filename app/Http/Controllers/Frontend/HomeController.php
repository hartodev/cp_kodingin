<?php

namespace App\Http\Controllers\Frontend;

// php artisan make:controller Frontend/HomeController

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        // Banner / Hero slider
        $banners = Banner::where('status', true)
            ->orderBy('order')
            ->get();

        // Kategori kursus
        $categories = CourseCategory::active()
            ->withCount(['courses' => fn($q) => $q->where('status', 'active')])
            ->get();

        // Kursus unggulan
        $featuredCourses = Course::with(['category', 'level'])
            ->where('status', 'active')
            ->withCount(['enrollments' => fn($q) => $q->where('have_access', true)])
            ->withAvg('reviews', 'rating')
            ->latest()
            ->limit(6)
            ->get();

        // Testimoni
        $testimonials = Testimonial::where('status', true)
            ->orderBy('order')
            ->limit(6)
            ->get();

        // FAQ
        $faqs = Faq::where('status', true)
            ->orderBy('order')
            ->limit(8)
            ->get();

        // Portfolio terbaru
        $portfolios = Portfolio::where('status', true)
            ->orderBy('order')
            ->limit(6)
            ->get();

        // Stats
        $stats = [
            'total_courses'     => Course::where('status', 'active')->count(),
            'total_enrollments' => \App\Models\Enrollment::where('have_access', true)->count(),
            'total_categories'  => CourseCategory::active()->count(),
        ];

        return view('frontend.home', compact(
            'banners',
            'categories',
            'featuredCourses',
            'testimonials',
            'faqs',
            'portfolios',
            'stats'
        ));
    }
}
