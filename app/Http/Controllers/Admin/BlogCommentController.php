<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
     public function index(Request $request)
    {
        $comments = BlogComment::with(['user', 'blog'])
            ->when($request->search, fn($q) => $q->where('comment', 'like', "%{$request->search}%"))
            ->when(isset($request->status), fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.blog-comments.index', compact('comments'));
    }

    public function destroy(BlogComment $blogComment)
    {
        $blogComment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    // ── Toggle status komentar ─────────────────────────────────────
    public function toggle(BlogComment $blogComment)
    {
        $blogComment->update(['status' => ! $blogComment->status]);

        $status = $blogComment->status ? 'ditampilkan' : 'disembunyikan';

        return back()->with('success', "Komentar berhasil {$status}.");
    }
}
