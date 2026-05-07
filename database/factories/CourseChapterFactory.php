<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseChapter>
 */
class CourseChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      $chapters = [
            'Pengenalan & Setup',
            'Dasar-dasar Fundamental',
            'Konsep Inti',
            'Studi Kasus & Praktik',
            'Fitur Lanjutan',
            'Optimasi & Best Practice',
            'Deploy & Production',
            'Project Akhir',
        ];
 
        static $order = 1;
 
        return [
            'course_id' => Course::factory(),
            'title'     => fake()->randomElement($chapters),
            'order'     => $order++,
            'status'    => true,
        ];
    }
 
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => false,
        ]);
    }
}