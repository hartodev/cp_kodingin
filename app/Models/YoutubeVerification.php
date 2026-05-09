<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class YoutubeVerification extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    // ── Relasi ke user yang mengajukan verifikasi ─────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Relasi ke order ───────────────────────────────────────────
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // ── Relasi ke admin yang memverifikasi ────────────────────────
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ── Scope: menunggu verifikasi ────────────────────────────────
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // ── Scope: sudah diapprove ────────────────────────────────────
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // ── Scope: ditolak ────────────────────────────────────────────
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // ── Helper: approve verifikasi ────────────────────────────────
    public function approve(int $adminId, ?string $note = null): void
    {
        $this->update([
            'status'      => 'approved',
            'admin_note'  => $note,
            'verified_by' => $adminId,
            'verified_at' => now(),
        ]);

        // Update status order jadi verified
        $this->order->update([
            'status'      => 'verified',
            'verified_at' => now(),
        ]);

        // Buat enrollment otomatis untuk semua kursus dalam order
        foreach ($this->order->items as $item) {
            Enrollment::firstOrCreate(
                ['user_id' => $this->user_id, 'course_id' => $item->course_id],
                ['order_id' => $this->order_id, 'have_access' => true, 'enrolled_at' => now()]
            );
        }

        // Kirim notifikasi ke user
        Notification::create([
            'user_id' => $this->user_id,
            'title'   => 'Verifikasi Subscribe Disetujui!',
            'message' => 'Selamat! Akses kursus kamu sudah dibuka. Selamat belajar!',
            'url'     => '/dashboard/my-courses',
        ]);
    }

    // ── Helper: reject verifikasi ─────────────────────────────────
    public function reject(int $adminId, ?string $note = null): void
    {
        $this->update([
            'status'      => 'rejected',
            'admin_note'  => $note,
            'verified_by' => $adminId,
            'verified_at' => now(),
        ]);

        // Update status order jadi failed
        $this->order->update(['status' => 'failed']);

        // Kirim notifikasi ke user
        Notification::create([
            'user_id' => $this->user_id,
            'title'   => 'Verifikasi Subscribe Ditolak',
            'message' => $note ?? 'Verifikasi subscribe kamu ditolak. Pastikan kamu sudah subscribe channel YouTube kami.',
            'url'     => '/checkout/' . $this->order_id,
        ]);
    }
}
