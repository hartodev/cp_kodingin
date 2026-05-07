<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseCategory>
 */
class CourseCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            ['name' => 'Web Development',    'icon' => 'fa-code'],
            ['name' => 'Mobile Development', 'icon' => 'fa-mobile-alt'],
            ['name' => 'UI/UX Design',       'icon' => 'fa-paint-brush'],
            ['name' => 'Data Science',       'icon' => 'fa-chart-bar'],
            ['name' => 'AI & Machine Learning', 'icon' => 'fa-robot'],
            ['name' => 'Cloud & DevOps',     'icon' => 'fa-cloud'],
            ['name' => 'Cybersecurity',      'icon' => 'fa-shield-alt'],
            ['name' => 'Game Development',   'icon' => 'fa-gamepad'],
        ];
 
        $category = fake()->unique()->randomElement($categories);
 
        return [
            'name'   => $category['name'],
            'slug'   => Str::slug($category['name']),
            'icon'   => $category['icon'],
            'image'  => null,
            'status' => true,
        ];
    }
 
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => false,
        ]);
    }
}