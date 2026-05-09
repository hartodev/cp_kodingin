<?php

namespace App\Http\Controllers\Admin;

// php artisan make:controller Admin/DiscussionReplyController

use App\Http\Controllers\Controller;
use App\Models\DiscussionReply;

class DiscussionReplyController extends Controller
{
    // Route: discussion-replies/{discussion_reply}
    public function destroy(DiscussionReply $discussionReply)
    {
        $discussionReply->delete();

        return back()->with('success', 'Balasan diskusi berhasil dihapus.');
    }
}