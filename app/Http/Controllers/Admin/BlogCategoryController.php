<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with(['category', 'user'])
            ->withCount('comments')
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->category, fn($q) => $q->where('blog_category_id', $request->category))
            ->when(isset($request->status), fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = BlogCategory::active()->get();

        return view('admin.blogs.index', compact('blogs', 'categories'));
    }

    public function create()
    {
        $categories = BlogCategory::active()->get();

        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'description'      => 'required|string',
            'seo_description'  => 'nullable|string|max:255',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'           => 'boolean',
        ]);

        $data          = $request->except(['image', '_token']);
        $data['slug']  = Str::slug($request->title);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog berhasil dipublikasikan.');
    }

    public function show(Blog $blog)
    {
        $blog->load(['category', 'comments.user']);

        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::active()->get();

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'description'      => 'required|string',
            'seo_description'  => 'nullable|string|max:255',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'           => 'boolean',
        ]);

        $data         = $request->except(['image', '_token', '_method']);
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog berhasil diperbarui.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog berhasil dihapus.');
    }
}
