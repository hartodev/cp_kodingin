<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

      protected $guarded = ['id'];
 
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'rating' => 'integer',
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
 
    // ── Scope: hanya yang aktif ───────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}