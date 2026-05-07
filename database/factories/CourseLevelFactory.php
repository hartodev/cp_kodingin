<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseLevel>
 */
class CourseLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          $levels = ['Beginner', 'Intermediate', 'Advanced', 'All Levels'];
        $name   = fake()->unique()->randomElement($levels);
 
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}