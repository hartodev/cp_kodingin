<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    use HasFactory;

      protected $guarded = ['id'];
 
    protected function casts(): array
    {
        return [
            'have_access' => 'boolean',
            'enrolled_at' => 'datetime',
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
 
    // ── Relasi ke order asal ──────────────────────────────────────
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
 
    // ── Scope: hanya yang punya akses aktif ───────────────────────
    public function scopeActive($query)
    {
        return $query->where('have_access', true);
    }
 
    // ── Helper: hitung persentase progress kursus ─────────────────
    public function getProgressPercentageAttribute(): int
    {
        $totalLessons = $this->course->lessons()->count();
        if ($totalLessons === 0) return 0;
 
        $completed = LessonProgress::where('user_id', $this->user_id)
            ->where('course_id', $this->course_id)
            ->where('is_completed', true)
            ->count();
 
        return (int) round(($completed / $totalLessons) * 100);
    }
}