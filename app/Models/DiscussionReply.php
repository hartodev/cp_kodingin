<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionReply extends Model
{
    use HasFactory;

    
    protected $guarded = ['id'];
 
    protected function casts(): array
    {
        return [
            'is_answer' => 'boolean',
        ];
    }
 
    // ── Relasi ke user (penjawab) ─────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
 
    // ── Relasi ke thread ──────────────────────────────────────────
    public function thread(): BelongsTo
    {
        return $this->belongsTo(DiscussionThread::class, 'thread_id');
    }
 
    // ── Helper: tandai sebagai jawaban terbaik ────────────────────
    public function markAsAnswer(): void
    {
        // Reset jawaban lain dalam thread yang sama
        static::where('thread_id', $this->thread_id)
            ->where('id', '!=', $this->id)
            ->update(['is_answer' => false]);
 
        $this->update(['is_answer' => true]);
 
        // Tandai thread sebagai solved
        $this->thread->update(['is_solved' => true]);
    }
}