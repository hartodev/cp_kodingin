<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
   use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    // ── Relasi ke user (penulis) ──────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Relasi ke kategori ────────────────────────────────────────
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    // ── Komentar blog ─────────────────────────────────────────────
    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class)->where('status', true);
    }

    // ── Scope: hanya yang aktif ───────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
