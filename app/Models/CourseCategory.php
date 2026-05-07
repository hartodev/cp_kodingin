<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseCategory extends Model
{
    use HasFactory;

    
    protected $guarded = ['id'];
 
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
 
    // ── Kursus dalam kategori ini ──────────────────────────────────
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'category_id');
    }
 
    // ── Scope: hanya yang aktif ────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}