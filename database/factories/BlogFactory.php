<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            '10 Tips Menjadi Developer Produktif di 2024',
            'Panduan Lengkap Belajar Laravel untuk Pemula',
            'Cara Deploy Aplikasi Laravel ke VPS dengan Mudah',
            'Kenapa Harus Belajar TypeScript Sekarang?',
            'Best Practice REST API Design yang Wajib Kamu Tahu',
            'Git Workflow untuk Tim Developer yang Efektif',
            'Panduan Setup VS Code untuk Web Developer',
            'Perbedaan SQL vs NoSQL, Mana yang Harus Dipilih?',
            'Cara Meningkatkan Performa Website dengan Caching',
            'Roadmap Belajar Full Stack Developer 2024',
        ];
 
        $title = fake()->unique()->randomElement($titles);
 
        return [
            'user_id'          => User::factory(),
            'blog_category_id' => BlogCategory::inRandomOrder()->first()?->id ?? BlogCategory::factory(),
            'title'            => $title,
            'slug'             => Str::slug($title) . '-' . fake()->unique()->numerify('###'),
            'image'            => null,
            'description'      => fake()->paragraphs(6, true),
            'seo_description'  => fake()->sentence(15),
            'status'           => fake()->boolean(85),
        ];
    }
 
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => true,
        ]);
    }
 
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => false,
        ]);
    }
}