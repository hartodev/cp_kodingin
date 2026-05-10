<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/DiscussionController

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\DiscussionThread;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    // POST /dashboard/courses/{course}/discussions
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'body'      => 'required|string|min:10|max:2000',
            'lesson_id' => 'nullable|exists:course_lessons,id',
        ], [
            'title.required' => 'Judul pertanyaan wajib diisi.',
            'body.required'  => 'Isi pertanyaan wajib diisi.',
            'body.min'       => 'Pertanyaan minimal 10 karakter.',
        ]);

        DiscussionThread::create([
            'user_id'   => auth()->id(),
            'course_id' => $course->id,
            'lesson_id' => $request->lesson_id,
            'title'     => $request->title,
            'body'      => $request->body,
        ]);

        return back()->with('success', 'Pertanyaan berhasil dikirim.');
    }

    // DELETE /dashboard/discussions/{thread}
    public function destroy(DiscussionThread $thread)
    {
        if ($thread->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak berhak menghapus diskusi ini.');
        }

        $thread->delete();

        return back()->with('success', 'Diskusi berhasil dihapus.');
    }
}
