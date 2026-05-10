<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/LearnController

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\LessonProgress;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    // GET /dashboard/learn/{course}
    // Redirect ke lesson pertama yang belum selesai
    public function index(Course $course)
    {
        $course->load([
            'chapters' => fn($q) => $q->where('status', true)->orderBy('order'),
            'chapters.lessons' => fn($q) => $q->where('status', true)->orderBy('order'),
        ]);

        // Ambil semua progress user untuk kursus ini
        $progress = LessonProgress::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->pluck('is_completed', 'lesson_id');

        // Cari lesson pertama yang belum selesai
        $allLessons = $course->chapters->flatMap->lessons;
        $firstLesson = $allLessons->first(fn($l) => ! ($progress[$l->id] ?? false))
            ?? $allLessons->first();

        if ($firstLesson) {
            return redirect()->route('user.learn.show', [$course, $firstLesson]);
        }

        // Kalau tidak ada lesson sama sekali
        return view('user.learn.index', compact('course', 'progress'));
    }

    // GET /dashboard/learn/{course}/{lesson}
    public function show(Course $course, CourseLesson $lesson)
    {
        // Pastikan lesson milik kursus ini
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $course->load([
            'chapters' => fn($q) => $q->where('status', true)->orderBy('order'),
            'chapters.lessons' => fn($q) => $q->where('status', true)->orderBy('order'),
        ]);

        // Progress semua lesson
        $progress = LessonProgress::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->pluck('is_completed', 'lesson_id');

        // Tandai lesson ini sudah dibuka (buat record progress jika belum ada)
        LessonProgress::firstOrCreate([
            'user_id'   => auth()->id(),
            'course_id' => $course->id,
            'lesson_id' => $lesson->id,
        ]);

        // Navigasi prev/next lesson
        $allLessons = $course->chapters->flatMap->lessons->values();
        $currentIdx = $allLessons->search(fn($l) => $l->id === $lesson->id);
        $prevLesson = $currentIdx > 0 ? $allLessons[$currentIdx - 1] : null;
        $nextLesson = $currentIdx < $allLessons->count() - 1 ? $allLessons[$currentIdx + 1] : null;

        // Cek apakah sudah bisa dapat sertifikat
        $totalLessons     = $allLessons->count();
        $completedLessons = collect($progress)->filter()->count();
        $canGetCert       = $totalLessons > 0 && $completedLessons >= $totalLessons;

        // Diskusi lesson ini
        $discussions = \App\Models\DiscussionThread::with(['user', 'replies.user'])
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->withCount('replies')
            ->latest()
            ->limit(10)
            ->get();

        return view('user.learn.show', compact(
            'course',
            'lesson',
            'progress',
            'prevLesson',
            'nextLesson',
            'canGetCert',
            'discussions'
        ));
    }

    // POST /dashboard/learn/{course}/{lesson}/progress
    public function updateProgress(Request $request, Course $course, CourseLesson $lesson)
    {
        $request->validate([
            'is_completed'    => 'boolean',
            'watched_seconds' => 'nullable|integer|min:0',
        ]);

        $lessonProgress = LessonProgress::firstOrCreate([
            'user_id'   => auth()->id(),
            'course_id' => $course->id,
            'lesson_id' => $lesson->id,
        ]);

        $lessonProgress->update([
            'is_completed'    => $request->boolean('is_completed', false),
            'watched_seconds' => $request->watched_seconds ?? $lessonProgress->watched_seconds,
        ]);

        // Hitung total progress
        $totalLessons = $course->chapters()
            ->where('status', true)
            ->with(['lessons' => fn($q) => $q->where('status', true)])
            ->get()
            ->flatMap->lessons
            ->count();

        $completedCount = LessonProgress::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->where('is_completed', true)
            ->count();

        $percentage = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100) : 0;

        return response()->json([
            'success'    => true,
            'percentage' => $percentage,
            'completed'  => $completedCount,
            'total'      => $totalLessons,
        ]);
    }
}
