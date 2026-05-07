<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LessonProgress>
 */
class LessonProgressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isCompleted = fake()->boolean(60);
 
        return [
            'user_id'         => User::factory(),
            'course_id'       => Course::factory(),
            'lesson_id'       => CourseLesson::factory(),
            'is_completed'    => $isCompleted,
            'watched_seconds' => $isCompleted ? fake()->numberBetween(300, 3600) : fake()->numberBetween(0, 299),
        ];
    }
 
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_completed'    => true,
            'watched_seconds' => fake()->numberBetween(600, 3600),
        ]);
    }
}