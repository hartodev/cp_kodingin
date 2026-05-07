<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\SettingSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // ── Urutan penting! Ikuti dependensi FK ───────────────
            UserSeeder::class,
            SettingSeeder::class,
            SocialLinkSeeder::class,
            BannerSeeder::class,
            CourseCategorySeeder::class,
            CourseLevelSeeder::class,
            CourseSeeder::class,
            TagSeeder::class,
            PortfolioSeeder::class,
            BlogCategorySeeder::class,
            BlogSeeder::class,
            TestimonialSeeder::class,
            FaqSeeder::class,
            OrderSeeder::class,       // buat order + youtube verification + enrollment
            ReviewSeeder::class,
            LessonProgressSeeder::class,
        ]);
    }
}