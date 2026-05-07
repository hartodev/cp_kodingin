<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseChapter extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
 
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
 
    // ── Relasi ke kursus ──────────────────────────────────────────
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
 
    // ── Lessons dalam bab ini ─────────────────────────────────────
    public function lessons(): HasMany
    {
        return $this->hasMany(CourseLesson::class, 'chapter_id')->orderBy('order');
    }
 
    // ── Scope: hanya yang aktif ───────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}