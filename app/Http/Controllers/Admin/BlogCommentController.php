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
            ->when($request->has('status'), fn($q) => $q->where('status', $request->status)) // ← fix: pakai has() bukan isset()
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
        // ── Fix: simpan nilai BARU dulu sebelum update ─────────────
        $newStatus = ! $blogComment->status;

        $blogComment->update(['status' => $newStatus]);

        // ← pakai $newStatus, bukan $blogComment->status (sudah berubah setelah update)
        $label = $newStatus ? 'ditampilkan' : 'disembunyikan';

        return back()->with('success', "Komentar berhasil {$label}.");
    }
}
