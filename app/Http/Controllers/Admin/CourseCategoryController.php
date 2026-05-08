<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
     public function index()
    {
        $categories = CourseCategory::withCount('courses')->latest()->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100|unique:course_categories,name',
            'icon'   => 'nullable|string|max:100',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'status' => 'boolean',
        ]);

        $data         = $request->except(['image', '_token']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        CourseCategory::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(CourseCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, CourseCategory $category)
    {
        $request->validate([
            'name'   => 'required|string|max:100|unique:course_categories,name,' . $category->id,
            'icon'   => 'nullable|string|max:100',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'status' => 'boolean',
        ]);

        $data         = $request->except(['image', '_token', '_method']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(CourseCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
