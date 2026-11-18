<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogBlock extends Model
{
    protected $guarded = [];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
