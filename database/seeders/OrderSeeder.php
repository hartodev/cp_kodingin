<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\YoutubeVerification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $users   = User::where('id', '!=', 1)->get();
        $courses = Course::where('status', 'active')->get();
        $admin   = User::first();
 
        foreach ($users as $user) {
            // Ambil 1-2 kursus random per user
            $selectedCourses = $courses->random(min(rand(1, 2), $courses->count()));
 
            foreach ($selectedCourses as $course) {
                // Lewati jika user sudah punya enrollment kursus ini
                if (Enrollment::where('user_id', $user->id)->where('course_id', $course->id)->exists()) {
                    continue;
                }
 
                $status = $this->randomStatus();
 
                // ── Buat Order ─────────────────────────────────────
                $order = Order::create([
                    'invoice_id'  => 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
                    'user_id'     => $user->id,
                    'status'      => $status,
                    'admin_note'  => $status === 'failed' ? 'Subscribe tidak ditemukan pada channel kami.' : null,
                    'verified_at' => $status === 'verified' ? now()->subDays(rand(1, 30)) : null,
                ]);
 
                // ── Buat Order Item ────────────────────────────────
                OrderItem::create([
                    'order_id'     => $order->id,
                    'course_id'    => $course->id,
                    'course_title' => $course->title,
                ]);
 
                // ── Buat YouTube Verification (kalau sudah melewati pending) ──
                if (in_array($status, ['waiting_verification', 'verified', 'failed'])) {
                    $verifStatus = match ($status) {
                        'verified' => 'approved',
                        'failed'   => 'rejected',
                        default    => 'pending',
                    };
 
                    YoutubeVerification::create([
                        'user_id'              => $user->id,
                        'order_id'             => $order->id,
                        'proof_image'          => null,
                        'youtube_channel_name' => $user->name . ' Channel',
                        'youtube_channel_url'  => 'https://youtube.com/@' . Str::slug($user->name),
                        'status'               => $verifStatus,
                        'admin_note'           => $verifStatus === 'rejected' ? 'Subscribe tidak ditemukan.' : null,
                        'verified_by'          => in_array($verifStatus, ['approved', 'rejected']) ? $admin->id : null,
                        'verified_at'          => in_array($verifStatus, ['approved', 'rejected']) ? now()->subDays(rand(1, 25)) : null,
                    ]);
                }
 
                // ── Buat Enrollment kalau verified ─────────────────
                if ($status === 'verified') {
                    Enrollment::create([
                        'user_id'     => $user->id,
                        'course_id'   => $course->id,
                        'order_id'    => $order->id,
                        'have_access' => true,
                        'enrolled_at' => now()->subDays(rand(1, 30)),
                    ]);
                }
            }
        }
    }
 
    private function randomStatus(): string
    {
        // Distribusi status yang realistis
        return fake()->randomElement([
            'pending',
            'waiting_verification',
            'verified', 'verified', 'verified', // lebih banyak verified
            'failed',
            'cancelled',
        ]);
    }
}