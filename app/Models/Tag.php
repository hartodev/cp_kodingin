<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    
    protected $guarded = ['id'];
 
    // ── Kursus dengan tag ini (many-to-many) ──────────────────────
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_tags');
    }
}