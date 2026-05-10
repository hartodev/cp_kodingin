<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/CertificateController

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\LessonProgress;

class CertificateController extends Controller
{
    // GET /dashboard/certificates
    public function index()
    {
        $certificates = Certificate::with('course.category')
            ->where('user_id', auth()->id())
            ->latest('issued_at')
            ->get();

        return view('user.certificates', compact('certificates'));
    }

    // GET /dashboard/learn/{course}/certificate
    public function show(Course $course)
    {
        $user = auth()->user();

        // Pastikan user enroll
        if (! $user->isEnrolled($course->id)) {
            abort(403, 'Kamu belum enroll kursus ini.');
        }

        $totalLessons = $course->chapters()
            ->where('status', true)
            ->with(['lessons' => fn($q) => $q->where('status', true)])
            ->get()
            ->flatMap->lessons
            ->count();

        $completedLessons = LessonProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('is_completed', true)
            ->count();

        if ($totalLessons === 0 || $completedLessons < $totalLessons) {
            return back()->with('error', 'Selesaikan semua materi terlebih dahulu untuk mendapatkan sertifikat. (' . $completedLessons . '/' . $totalLessons . ' lesson selesai)');
        }

        // Buat atau ambil sertifikat
        $certificate = Certificate::firstOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            [
                'certificate_number' => Certificate::generateNumber(),
                'issued_at'          => now(),
            ]
        );

        return view('user.certificate-show', compact('certificate', 'course'));
    }

    // GET /dashboard/learn/{course}/certificate/download
    public function download(Course $course)
    {
        $certificate = Certificate::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->firstOrFail();

        // TODO: Generate PDF sertifikat
        // Untuk sementara redirect ke halaman view
        return redirect()->route('user.learn.certificate', $course)
            ->with('info', 'Fitur download sertifikat PDF segera hadir!');
    }
}
