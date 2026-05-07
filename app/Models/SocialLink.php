<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    
    protected $guarded = ['id'];
 
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
 
    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('order');
    }
}