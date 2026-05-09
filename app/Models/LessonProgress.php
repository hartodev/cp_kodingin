<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonProgress extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
        ];
    }

    // ── Relasi ke user ────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Relasi ke kursus ──────────────────────────────────────────
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // ── Relasi ke lesson ──────────────────────────────────────────
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(CourseLesson::class, 'lesson_id');
    }
}
