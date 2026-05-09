<?php

namespace App\Http\Controllers\Admin;

// php artisan make:controller Admin/CourseChapterController --resource

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseChapter;
use Illuminate\Http\Request;

class CourseChapterController extends Controller
{
    // Route: courses/{course}/chapters
    public function index(Course $course)
    {
        $course->load('chapters.lessons');

        return view('admin.courses.chapters.index', compact('course'));
    }

    public function create(Course $course)
    {
        return view('admin.courses.chapters.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        $order = $course->chapters()->max('order') + 1;

        $course->chapters()->create([
            'title'  => $request->title,
            'order'  => $order,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.courses.chapters.index', $course)
            ->with('success', 'Chapter berhasil ditambahkan.');
    }

    // Route: courses/{course}/chapters/{chapter}
    public function edit(Course $course, CourseChapter $chapter)
    {
        return view('admin.courses.chapters.edit', compact('course', 'chapter'));
    }

    public function update(Request $request, Course $course, CourseChapter $chapter)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        $chapter->update([
            'title'  => $request->title,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.courses.chapters.index', $course)
            ->with('success', 'Chapter berhasil diperbarui.');
    }

    public function destroy(Course $course, CourseChapter $chapter)
    {
        $chapter->delete();

        return redirect()->route('admin.courses.chapters.index', $course)
            ->with('success', 'Chapter berhasil dihapus.');
    }

    public function reorder(Request $request, Course $course)
    {
        $request->validate(['orders' => 'required|array']);

        foreach ($request->orders as $item) {
            CourseChapter::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}