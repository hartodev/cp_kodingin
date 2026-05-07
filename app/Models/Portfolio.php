<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
 
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
 
    // ── Relasi ke user (owner) ────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
 
    // ── Scope: hanya yang aktif ───────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('order');
    }
}