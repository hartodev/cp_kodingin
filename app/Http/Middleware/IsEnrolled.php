<?php

namespace App\Http\Middleware;

use App\Models\Enrollment;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsEnrolled
{
    public function handle(Request $request, Closure $next): Response
    {
        $user   = Auth::user();
        $course = $request->route('course');

        // Admin bypass — admin bisa akses semua
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Cek enrollment
        $enrolled = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('have_access', true)
            ->exists();

        if (! $enrolled) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kamu belum memiliki akses ke kursus ini.',
                ], 403);
            }

            return redirect()->route('user.my-courses')
                ->with('error', 'Kamu belum memiliki akses ke kursus ini. Selesaikan verifikasi YouTube terlebih dahulu.');
        }

        return $next($request);
    }
}
