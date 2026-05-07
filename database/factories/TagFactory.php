<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = [
            'Laravel', 'React', 'Vue', 'Node.js', 'Python',
            'JavaScript', 'TypeScript', 'Flutter', 'Docker',
            'MySQL', 'MongoDB', 'Redis', 'REST API', 'GraphQL',
            'Tailwind CSS', 'Bootstrap', 'Git', 'Linux', 'AWS',
        ];
 
        $name = fake()->unique()->randomElement($tags);
 
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}