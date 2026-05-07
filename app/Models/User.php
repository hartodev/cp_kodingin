<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

  
    protected $guarded = ['id'];
 
    protected $hidden = [
        'password',
        'remember_token',
    ];
 
    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'is_youtube_verified' => 'boolean',
            'password'            => 'hashed',
        ];
    }
 
    // ── Courses yang dibuat owner ──────────────────────────────────
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
 
    // ── Enrollments (kursus yang diakses user) ─────────────────────
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
 
    // ── Orders / Checkout ──────────────────────────────────────────
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
 
    // ── Verifikasi YouTube ─────────────────────────────────────────
    public function youtubeVerifications()
    {
        return $this->hasMany(YoutubeVerification::class);
    }
 
    // ── Reviews ───────────────────────────────────────────────────
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
 
    // ── Wishlist ───────────────────────────────────────────────────
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
 
    // ── Cart ───────────────────────────────────────────────────────
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
 
    // ── Progress belajar ───────────────────────────────────────────
    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class);
    }
 
    // ── Sertifikat ─────────────────────────────────────────────────
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
 
    // ── Notifikasi ─────────────────────────────────────────────────
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
 
    // ── Blog yang ditulis ──────────────────────────────────────────
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
 
    // ── Komentar blog ──────────────────────────────────────────────
    public function blogComments()
    {
        return $this->hasMany(BlogComment::class);
    }
 
    // ── Portfolio ──────────────────────────────────────────────────
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }
 
    // ── Thread diskusi ─────────────────────────────────────────────
    public function discussionThreads()
    {
        return $this->hasMany(DiscussionThread::class);
    }
 
    // ── Balasan diskusi ────────────────────────────────────────────
    public function discussionReplies()
    {
        return $this->hasMany(DiscussionReply::class);
    }
 
    // ── Helper: cek apakah sudah enroll kursus tertentu ───────────
    public function isEnrolled(int $courseId): bool
    {
        return $this->enrollments()
            ->where('course_id', $courseId)
            ->where('have_access', true)
            ->exists();
    }
 
    // ── Helper: cek apakah kursus ada di wishlist ──────────────────
    public function isWishlisted(int $courseId): bool
    {
        return $this->wishlists()->where('course_id', $courseId)->exists();
    }
 
    // ── Helper: cek apakah kursus ada di cart ──────────────────────
    public function isInCart(int $courseId): bool
    {
        return $this->carts()->where('course_id', $courseId)->exists();
    }
}