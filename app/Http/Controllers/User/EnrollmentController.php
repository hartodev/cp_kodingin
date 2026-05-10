<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/EnrollmentController

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\LessonProgress;

class EnrollmentController extends Controller
{
    // GET /dashboard/my-courses
    public function index()
    {
        $enrollments = Enrollment::with(['course.category', 'course.chapters.lessons'])
            ->where('user_id', auth()->id())
            ->where('have_access', true)
            ->latest()
            ->paginate(12);

        // Hitung progress tiap kursus
        $progressData = [];
        foreach ($enrollments as $enrollment) {
            $totalLessons = $enrollment->course->chapters
                ->flatMap->lessons
                ->where('status', true)
                ->count();

            $completedLessons = LessonProgress::where('user_id', auth()->id())
                ->where('course_id', $enrollment->course_id)
                ->where('is_completed', true)
                ->count();

            $progressData[$enrollment->course_id] = $totalLessons > 0
                ? round(($completedLessons / $totalLessons) * 100)
                : 0;
        }

        return view('user.my-courses', compact('enrollments', 'progressData'));
    }
}
