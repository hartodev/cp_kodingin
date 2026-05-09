<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
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

    // ── Helper: generate nomor sertifikat ─────────────────────────
    public static function generateNumber(): string
    {
        $latest = static::latest()->first();
        $number = $latest ? (int) substr($latest->certificate_number, -5) + 1 : 1;
        return 'CERT-' . now()->format('Y') . '-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
}
