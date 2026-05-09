<?php

namespace App\Http\Controllers\Admin;

// php artisan make:controller Admin/CourseLessonController --resource

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseLessonController extends Controller
{
    // Route: courses/{course}/chapters/{chapter}/lessons
    public function create(Course $course, CourseChapter $chapter)
    {
        return view('admin.courses.lessons.create', compact('course', 'chapter'));
    }

    public function store(Request $request, Course $course, CourseChapter $chapter)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'file_path'    => 'nullable|string',
            'storage'      => 'required|in:upload,youtube,vimeo,external_link',
            'file_type'    => 'required|in:video,audio,pdf,doc,file',
            'duration'     => 'nullable|string|max:20',
            'is_preview'   => 'boolean',
            'downloadable' => 'boolean',
            'status'       => 'boolean',
        ]);

        $order = $chapter->lessons()->max('order') + 1;
        $slug  = Str::slug($request->title) . '-' . $course->id . '-' . $chapter->id . '-' . $order;

        CourseLesson::create([
            'course_id'    => $course->id,
            'chapter_id'   => $chapter->id,
            'title'        => $request->title,
            'slug'         => $slug,
            'description'  => $request->description,
            'file_path'    => $request->file_path,
            'storage'      => $request->storage,
            'file_type'    => $request->file_type,
            'duration'     => $request->duration,
            'is_preview'   => $request->boolean('is_preview'),
            'downloadable' => $request->boolean('downloadable'),
            'order'        => $order,
            'status'       => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.courses.chapters.index', $course)
            ->with('success', 'Lesson berhasil ditambahkan.');
    }

    // Route: courses/{course}/chapters/{chapter}/lessons/{lesson}
    public function edit(Course $course, CourseChapter $chapter, CourseLesson $lesson)
    {
        return view('admin.courses.lessons.edit', compact('course', 'chapter', 'lesson'));
    }

    public function update(Request $request, Course $course, CourseChapter $chapter, CourseLesson $lesson)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'file_path'    => 'nullable|string',
            'storage'      => 'required|in:upload,youtube,vimeo,external_link',
            'file_type'    => 'required|in:video,audio,pdf,doc,file',
            'duration'     => 'nullable|string|max:20',
            'is_preview'   => 'boolean',
            'downloadable' => 'boolean',
            'status'       => 'boolean',
        ]);

        $lesson->update([
            'title'        => $request->title,
            'description'  => $request->description,
            'file_path'    => $request->file_path,
            'storage'      => $request->storage,
            'file_type'    => $request->file_type,
            'duration'     => $request->duration,
            'is_preview'   => $request->boolean('is_preview'),
            'downloadable' => $request->boolean('downloadable'),
            'status'       => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.courses.chapters.index', $course)
            ->with('success', 'Lesson berhasil diperbarui.');
    }

    public function destroy(Course $course, CourseChapter $chapter, CourseLesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('admin.courses.chapters.index', $course)
            ->with('success', 'Lesson berhasil dihapus.');
    }

    public function reorder(Request $request, Course $course, CourseChapter $chapter)
    {
        $request->validate(['orders' => 'required|array']);

        foreach ($request->orders as $item) {
            CourseLesson::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}