<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/DiscussionReplyController

use App\Http\Controllers\Controller;
use App\Models\DiscussionReply;
use App\Models\DiscussionThread;
use Illuminate\Http\Request;

class DiscussionReplyController extends Controller
{
    // POST /dashboard/discussions/{thread}/replies
    public function store(Request $request, DiscussionThread $thread)
    {
        $request->validate([
            'body' => 'required|string|min:5|max:2000',
        ], [
            'body.required' => 'Balasan wajib diisi.',
            'body.min'      => 'Balasan minimal 5 karakter.',
        ]);

        DiscussionReply::create([
            'user_id'   => auth()->id(),
            'thread_id' => $thread->id,
            'body'      => $request->body,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    // POST /dashboard/discussions/replies/{reply}/answer
    public function markAnswer(DiscussionReply $reply)
    {
        $thread = $reply->thread;

        // Hanya pembuat thread yang bisa tandai jawaban terbaik
        if ($thread->user_id !== auth()->id()) {
            abort(403, 'Hanya pembuat pertanyaan yang bisa menandai jawaban terbaik.');
        }

        $reply->markAsAnswer();

        return back()->with('success', 'Jawaban terbaik berhasil dipilih!');
    }

    // DELETE /dashboard/discussions/replies/{reply}
    public function destroy(DiscussionReply $reply)
    {
        if ($reply->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak berhak menghapus balasan ini.');
        }

        $reply->delete();

        return back()->with('success', 'Balasan berhasil dihapus.');
    }
}
