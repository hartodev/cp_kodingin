<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // ── Owner / Admin utama ────────────────────────────────────
        User::create([
            'name'                => 'Admin PanduanFlow',
            'email'               => 'admin@panduanflow.com',
            'password'            => Hash::make('password'),
            'image'               => '/default-files/avatar.png',
            'headline'            => 'Founder & Educator at PanduanFlow',
            'bio'                 => 'Seorang developer dan educator yang passionate di bidang teknologi. Sudah 5 tahun mengajar dan membantu ribuan developer berkembang.',
            'gender'              => 'male',
            'github'              => 'https://github.com/panduanflow',
            'linkedin'            => 'https://linkedin.com/in/panduanflow',
            'instagram'           => 'https://instagram.com/panduanflow',
            'website'             => 'https://panduanflow.com',
            'is_youtube_verified' => true,
            'email_verified_at'   => now(),
        ]);
 
        // ── User dummy yang sudah verified YouTube ─────────────────
        User::factory(30)->youtubeVerified()->create();
 
        // ── User dummy yang belum verified YouTube ─────────────────
        User::factory(10)->youtubeUnverified()->create();
    }
}