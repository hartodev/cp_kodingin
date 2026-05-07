<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
  use HasFactory, SoftDeletes;
 
    protected $guarded = ['id'];
 
    protected function casts(): array
    {
        return [
            'certificate'               => 'boolean',
            'qna'                       => 'boolean',
            'require_youtube_subscribe' => 'boolean',
        ];
    }
 
    // ── Relasi ke owner (user yang buat kursus) ────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
 
    // ── Relasi ke kategori ─────────────────────────────────────────
    public function category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class);
    }
 
    // ── Relasi ke level ────────────────────────────────────────────
    public function level(): BelongsTo
    {
        return $this->belongsTo(CourseLevel::class, 'course_level_id');
    }
 
    // ── Chapters / bab ────────────────────────────────────────────
    public function chapters(): HasMany
    {
        return $this->hasMany(CourseChapter::class)->orderBy('order');
    }
 
    // ── Semua lessons (melewati chapters) ─────────────────────────
    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(CourseLesson::class, CourseChapter::class, 'course_id', 'chapter_id')
                    ->orderBy('order');
    }
 
    // ── Enrollments ───────────────────────────────────────────────
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
 
    // ── Reviews ───────────────────────────────────────────────────
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', true);
    }
 
    // ── Wishlist ──────────────────────────────────────────────────
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
 
    // ── Cart ──────────────────────────────────────────────────────
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
 
    // ── Tags (many-to-many) ───────────────────────────────────────
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'course_tags');
    }
 
    // ── Sertifikat ────────────────────────────────────────────────
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
 
    // ── Thread diskusi ────────────────────────────────────────────
    public function discussionThreads(): HasMany
    {
        return $this->hasMany(DiscussionThread::class);
    }
 
    // ── Progress belajar ──────────────────────────────────────────
    public function lessonProgress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }
 
    // ── Scope: hanya kursus aktif ─────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
 
    // ── Helper: rata-rata rating ──────────────────────────────────
    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
 
    // ── Helper: jumlah student ────────────────────────────────────
    public function getStudentCountAttribute(): int
    {
        return $this->enrollments()->where('have_access', true)->count();
    }
 
    // ── Helper: total lesson ──────────────────────────────────────
    public function getLessonCountAttribute(): int
    {
        return $this->lessons()->count();
    }
}