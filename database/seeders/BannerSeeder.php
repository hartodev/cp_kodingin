<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
             Banner::create([
            'title'       => 'Master Skills Next Level',
            'subtitle'    => 'Platform belajar paling modern dengan AI-powered curriculum. Subscribe YouTube kami dan dapatkan akses kursus premium secara gratis!',
            'image'       => null,
            'button_text' => '🚀 Mulai Sekarang',
            'button_url'  => '/courses',
            'order'       => 1,
            'status'      => true,
        ]);
    }
}