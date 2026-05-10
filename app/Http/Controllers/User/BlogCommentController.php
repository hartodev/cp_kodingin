<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/BlogCommentController

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    // POST /dashboard/blog/{blog}/comments
    public function store(Request $request, Blog $blog)
    {
        $request->validate([
            'comment' => 'required|string|min:5|max:1000',
        ], [
            'comment.required' => 'Komentar wajib diisi.',
            'comment.min'      => 'Komentar minimal 5 karakter.',
        ]);

        BlogComment::create([
            'user_id' => auth()->id(),
            'blog_id' => $blog->id,
            'comment' => $request->comment,
            'status'  => true,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    // DELETE /dashboard/blog/comments/{comment}
    public function destroy(BlogComment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak berhak menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
