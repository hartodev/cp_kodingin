<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseLesson extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_preview'   => 'boolean',
            'downloadable' => 'boolean',
            'status'       => 'boolean',
        ];
    }

    // ── Relasi ke kursus ──────────────────────────────────────────
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // ── Relasi ke chapter ─────────────────────────────────────────
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(CourseChapter::class);
    }

    // ── Progress user di lesson ini ───────────────────────────────
    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class, 'lesson_id');
    }

    // ── Thread diskusi di lesson ini ──────────────────────────────
    public function discussionThreads(): HasMany
    {
        return $this->hasMany(DiscussionThread::class, 'lesson_id');
    }

    // ── Scope: hanya yang aktif ───────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // ── Helper: cek apakah user sudah selesaikan lesson ini ───────
    public function isCompletedBy(int $userId): bool
    {
        return $this->progress()
            ->where('user_id', $userId)
            ->where('is_completed', true)
            ->exists();
    }
}
