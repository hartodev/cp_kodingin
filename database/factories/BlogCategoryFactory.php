<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogCategory>
 */
class BlogCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $categories = [
            'Tutorial',
            'Tips & Tricks',
            'Panduan',
            'Review Tools',
            'Karir Developer',
            'News & Update',
        ];
 
        $name = fake()->unique()->randomElement($categories);
 
        return [
            'name'   => $name,
            'slug'   => Str::slug($name),
            'status' => true,
        ];
    }
}