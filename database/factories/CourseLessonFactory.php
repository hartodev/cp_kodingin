<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseChapter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseLesson>
 */
class CourseLessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
           $lessonTitles = [
            'Instalasi & Konfigurasi',
            'Hello World & Struktur Dasar',
            'Variable, Tipe Data & Operator',
            'Kondisi & Perulangan',
            'Function & Arrow Function',
            'Array & Object',
            'Async/Await & Promise',
            'API Integration',
            'State Management',
            'Routing & Navigation',
            'Database Connection',
            'CRUD Operations',
            'Authentication & Authorization',
            'Upload File & Storage',
            'Testing & Debugging',
        ];
 
        $title = fake()->randomElement($lessonTitles);
 
        static $order = 1;
 
        return [
            'course_id'    => Course::factory(),
            'chapter_id'   => CourseChapter::factory(),
            'title'        => $title,
            'slug'         => Str::slug($title) . '-' . fake()->unique()->numerify('###'),
            'description'  => fake()->paragraph(),
            'file_path'    => 'https://www.youtube.com/watch?v=' . Str::random(11),
            'storage'      => 'youtube',
            'file_type'    => 'video',
            'duration'     => fake()->numerify('##') . ':' . fake()->numerify('##'),
            'volume'       => null,
            'is_preview'   => fake()->boolean(20), // 20% bisa preview gratis
            'downloadable' => false,
            'order'        => $order++,
            'status'       => true,
        ];
    }
 
    // ── State: bisa dipreview tanpa enroll ────────────────────────
    public function preview(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_preview' => true,
        ]);
    }
}