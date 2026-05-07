<?php

namespace Database\Factories;

use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       
        $titles = [
            'Fullstack Web Development dengan Laravel & Vue',
            'Belajar React JS dari Nol sampai Mahir',
            'Flutter untuk Pemula: Buat Aplikasi iOS & Android',
            'Machine Learning dengan Python & TensorFlow',
            'UI/UX Design Mastery dengan Figma',
            'Node.js & Express REST API Development',
            'Docker & Kubernetes untuk Developer',
            'JavaScript Modern ES6+ Lengkap',
            'PHP OOP & Design Pattern',
            'Next.js Full Stack Development',
        ];
 
        $title = fake()->unique()->randomElement($titles);
 
        return [
            'user_id'                   => User::factory(),
            'category_id'               => CourseCategory::inRandomOrder()->first()?->id,
            'course_level_id'           => CourseLevel::inRandomOrder()->first()?->id,
            'title'                     => $title,
            'slug'                      => Str::slug($title) . '-' . fake()->unique()->numerify('###'),
            'seo_description'           => fake()->sentence(15),
            'description'               => fake()->paragraphs(4, true),
            'thumbnail'                 => null,
            'demo_video_storage'        => 'youtube',
            'demo_video_source'         => 'https://www.youtube.com/watch?v=' . Str::random(11),
            'duration'                  => fake()->randomElement(['5 jam', '10 jam', '15 jam', '20 jam 30 menit']),
            'certificate'               => fake()->boolean(80),
            'qna'                       => fake()->boolean(60),
            'require_youtube_subscribe' => true,
            'status'                    => fake()->randomElement(['active', 'active', 'draft']),
        ];
    }
 
    // ── State: kursus aktif ───────────────────────────────────────
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }
 
    // ── State: kursus draft ───────────────────────────────────────
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }
 
    // ── State: tanpa syarat subscribe ─────────────────────────────
    public function noSubscribeRequired(): static
    {
        return $this->state(fn (array $attributes) => [
            'require_youtube_subscribe' => false,
        ]);
    }
}