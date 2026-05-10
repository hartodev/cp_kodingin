<?php

namespace App\Http\Controllers\Frontend;

// php artisan make:controller Frontend/BlogController

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with(['category', 'user'])
            ->withCount(['comments' => fn($q) => $q->where('status', true)])
            ->where('status', true)
            ->when(
                $request->search,
                fn($q) =>
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%")
            )
            ->when(
                $request->category,
                fn($q) =>
                $q->whereHas('category', fn($q) => $q->where('slug', $request->category))
            )
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $categories = BlogCategory::active()
            ->withCount(['blogs' => fn($q) => $q->where('status', true)])
            ->get();

        // Blog populer (sidebar)
        $popularBlogs = Blog::where('status', true)
            ->withCount(['comments' => fn($q) => $q->where('status', true)])
            ->orderByDesc('comments_count')
            ->limit(5)
            ->get();

        return view('frontend.blog.index', compact('blogs', 'categories', 'popularBlogs'));
    }

    // Route: /blog/{slug}
    public function show(string $slug)
    {
        $blog = Blog::with([
            'category',
            'user',
            'comments' => fn($q) => $q->where('status', true)->with('user')->latest(),
        ])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        // Blog terkait
        $relatedBlogs = Blog::with('category')
            ->where('status', true)
            ->where('id', '!=', $blog->id)
            ->where('blog_category_id', $blog->blog_category_id)
            ->latest()
            ->limit(3)
            ->get();

        // Blog lainnya (sidebar)
        $recentBlogs = Blog::where('status', true)
            ->where('id', '!=', $blog->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('frontend.blog.show', compact('blog', 'relatedBlogs', 'recentBlogs'));
    }
}
