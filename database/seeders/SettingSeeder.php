<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $settings = [
            // ── Identitas Website ──────────────────────────────────
            'site_name'              => 'KodinginYuk',
            'site_tagline'           => 'Next Gen Learning Platform',
            'site_description'       => 'Platform belajar paling modern dengan AI-powered curriculum. Transformasi karir Anda dalam hitungan minggu.',
            'site_email'             => 'hello@KodinginYuk.com',
            'site_phone'             => '+62 812-3456-7890',
            'site_address'           => 'Temanggung, Jawa Tengah, Indonesia',
            'site_logo'              => null,
            'site_favicon'           => null,

            // ── YouTube Channel ────────────────────────────────────
            'youtube_channel_url'    => 'https://youtube.com/@KodinginYuk',
            'youtube_channel_name'   => 'KodinginYuk',
            'youtube_channel_id'     => 'UC_KodinginYuk_channel_id',

            // ── SEO ────────────────────────────────────────────────
            'meta_title'             => 'KodinginYuk - Next Gen Learning Platform',
            'meta_description'       => 'Belajar programming dan desain dari expert. Subscribe YouTube kami untuk akses kursus premium gratis.',
            'meta_keywords'          => 'belajar coding, kursus programming, web development, laravel, react',
            'google_analytics_id'    => null,

            // ── Copyright ──────────────────────────────────────────
            'footer_copyright'       => '© ' . date('Y') . ' KodinginYuk. All rights reserved.',
            'footer_description'     => 'Future of learning. Designed for the next generation of professionals.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
