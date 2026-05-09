<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    // ── Relasi ke user ────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Item kursus dalam order ini ───────────────────────────────
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Verifikasi YouTube untuk order ini ────────────────────────
    public function youtubeVerification(): HasOne
    {
        return $this->hasOne(YoutubeVerification::class);
    }

    // ── Enrollments yang lahir dari order ini ─────────────────────
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    // ── Scope: menunggu verifikasi ────────────────────────────────
    public function scopeWaitingVerification($query)
    {
        return $query->where('status', 'waiting_verification');
    }

    // ── Scope: sudah verified ─────────────────────────────────────
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    // ── Helper: cek apakah order ini sudah verified ───────────────
    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    // ── Helper: generate invoice ID ───────────────────────────────
    public static function generateInvoiceId(): string
    {
        $latest = static::latest()->first();
        $number = $latest ? (int) substr($latest->invoice_id, -4) + 1 : 1;
        return 'INV-' . now()->format('Ymd') . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
