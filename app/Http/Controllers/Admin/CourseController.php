<?php

namespace App\Http\Controllers\Admin;

// php artisan make:controller Admin/CourseController --resource

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with(['category', 'level'])
            ->withCount(['enrollments' => fn($q) => $q->where('have_access', true), 'reviews'])
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = CourseCategory::active()->get();

        return view('admin.courses.index', compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = CourseCategory::active()->get();
        $levels     = CourseLevel::all();
        $tags       = Tag::all();

        return view('admin.courses.create', compact('categories', 'levels', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'                     => 'required|string|max:255',
            'category_id'               => 'nullable|exists:course_categories,id',
            'course_level_id'           => 'nullable|exists:course_levels,id',
            'description'               => 'nullable|string',
            'seo_description'           => 'nullable|string|max:255',
            'thumbnail'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'demo_video_storage'        => 'nullable|in:upload,youtube,vimeo,external_link',
            'demo_video_source'         => 'nullable|string',
            'duration'                  => 'nullable|string|max:100',
            'certificate'               => 'boolean',
            'qna'                       => 'boolean',
            'require_youtube_subscribe' => 'boolean',
            'status'                    => 'required|in:draft,active,inactive',
            'tags'                      => 'nullable|array',
            'tags.*'                    => 'exists:tags,id',
        ]);

        $data            = $request->except(['thumbnail', 'tags', '_token']);
        $data['slug']    = Str::slug($request->title) . '-' . Str::random(5);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        $course = Course::create($data);

        if ($request->tags) {
            $course->tags()->sync($request->tags);
        }

        return redirect()->route('admin.courses.index')
            ->with('success', 'Kursus berhasil dibuat.');
    }

    public function show(Course $course)
    {
        $course->load(['category', 'level', 'tags', 'chapters.lessons', 'enrollments.user', 'reviews.user']);

        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories = CourseCategory::active()->get();
        $levels     = CourseLevel::all();
        $tags       = Tag::all();
        $course->load('tags');

        return view('admin.courses.edit', compact('course', 'categories', 'levels', 'tags'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title'                     => 'required|string|max:255',
            'category_id'               => 'nullable|exists:course_categories,id',
            'course_level_id'           => 'nullable|exists:course_levels,id',
            'description'               => 'nullable|string',
            'seo_description'           => 'nullable|string|max:255',
            'thumbnail'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'demo_video_storage'        => 'nullable|in:upload,youtube,vimeo,external_link',
            'demo_video_source'         => 'nullable|string',
            'duration'                  => 'nullable|string|max:100',
            'certificate'               => 'boolean',
            'qna'                       => 'boolean',
            'require_youtube_subscribe' => 'boolean',
            'status'                    => 'required|in:draft,active,inactive',
            'tags'                      => 'nullable|array',
            'tags.*'                    => 'exists:tags,id',
        ]);

        $data = $request->except(['thumbnail', 'tags', '_token', '_method']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        $course->update($data);
        $course->tags()->sync($request->tags ?? []);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Kursus berhasil dihapus.');
    }
}