<?php

namespace App\Http\Controllers\Admin;

// php artisan make:controller Admin/EnrollmentController

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $enrollments = Enrollment::with(['user', 'course'])
            ->when($request->search, fn($q) => $q->whereHas('user', fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
            ))
            ->when($request->course, fn($q) => $q->where('course_id', $request->course))
            ->when($request->access, fn($q) => $q->where('have_access', $request->access === 'yes'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.enrollments.index', compact('enrollments'));
    }

    // Route: enrollments/{enrollment}
    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['user', 'course', 'order']);

        return view('admin.enrollments.show', compact('enrollment'));
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment berhasil dihapus.');
    }

    // Route: enrollments/{enrollment}/toggle-access
    public function toggleAccess(Enrollment $enrollment)
    {
        $newAccess = ! $enrollment->have_access;

        $enrollment->update(['have_access' => $newAccess]);

        $label = $newAccess ? 'dibuka' : 'dicabut';

        return back()->with('success', "Akses kursus berhasil {$label}.");
    }
}