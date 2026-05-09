<?php

namespace App\Http\Controllers\Admin;

// php artisan make:controller Admin/BlogCommentController

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = BlogComment::with(['user', 'blog'])
            ->when($request->search, fn($q) => $q->where('comment', 'like', "%{$request->search}%"))
            ->when($request->has('status'), fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.blog-comments.index', compact('comments'));
    }

    // Route: blog-comments/{comment} ← parameter harus $comment
    public function destroy(BlogComment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    // Route: blog-comments/{comment}/toggle ← parameter harus $comment
    public function toggle(BlogComment $comment)
    {
        $newStatus = ! $comment->status;

        $comment->update(['status' => $newStatus]);

        $label = $newStatus ? 'ditampilkan' : 'disembunyikan';

        return back()->with('success', "Komentar berhasil {$label}.");
    }
}