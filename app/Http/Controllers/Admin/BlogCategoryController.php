<?php

namespace App\Http\Controllers\Admin;

// php artisan make:controller Admin/BlogCategoryController --resource

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('blogs')->latest()->paginate(15);

        return view('admin.blog-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.blog-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100|unique:blog_categories,name',
            'status' => 'boolean',
        ]);

        BlogCategory::create([
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Kategori blog berhasil ditambahkan.');
    }

    // Route: blog-categories/{blog_category}
    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.edit', compact('blogCategory'));
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $request->validate([
            'name'   => 'required|string|max:100|unique:blog_categories,name,' . $blogCategory->id,
            'status' => 'boolean',
        ]);

        $blogCategory->update([
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Kategori blog berhasil diperbarui.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Kategori blog berhasil dihapus.');
    }
}