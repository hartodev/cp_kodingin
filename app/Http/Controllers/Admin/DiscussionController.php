<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscussionReply;
use App\Models\DiscussionThread;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
      public function index(Request $request)
    {
        $threads = DiscussionThread::with(['user', 'course', 'lesson'])
            ->withCount('replies')
            ->when($request->search, fn($q) =>
                $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->course, fn($q) =>
                $q->where('course_id', $request->course))
            ->when(isset($request->is_solved), fn($q) =>
                $q->where('is_solved', $request->is_solved))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.discussions.index', compact('threads'));
    }

    public function show(DiscussionThread $discussion)
    {
        $discussion->load(['user', 'course', 'lesson', 'replies.user']);

        return view('admin.discussions.show', compact('discussion'));
    }

    public function destroy(DiscussionThread $discussion)
    {
        $discussion->delete();

        return redirect()->route('admin.discussions.index')
            ->with('success', 'Thread diskusi berhasil dihapus.');
    }
}


// ──────────────────────────────────────────────────────────────
// DISCUSSION REPLY CONTROLLER
// php artisan make:controller Admin/DiscussionReplyController
// ──────────────────────────────────────────────────────────────

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscussionReply;

class DiscussionReplyController extends Controller
{
    public function destroy(DiscussionReply $discussionReply)
    {
        $discussionReply->delete();

        return back()->with('success', 'Balasan diskusi berhasil dihapus.');
    }
}
