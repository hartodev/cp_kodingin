<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscussionThread extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_solved' => 'boolean',
        ];
    }

    // ── Relasi ke user (penanya) ──────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Relasi ke kursus ──────────────────────────────────────────
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // ── Relasi ke lesson (opsional) ───────────────────────────────
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(CourseLesson::class, 'lesson_id');
    }

    // ── Balasan thread ────────────────────────────────────────────
    public function replies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class, 'thread_id');
    }

    // ── Jawaban terbaik ───────────────────────────────────────────
    public function bestAnswer()
    {
        return $this->replies()->where('is_answer', true)->first();
    }

    // ── Scope: belum terjawab ─────────────────────────────────────
    public function scopeUnsolved($query)
    {
        return $query->where('is_solved', false);
    }
}
