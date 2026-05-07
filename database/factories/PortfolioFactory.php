<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio>
 */
class PortfolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projects = [
            'E-Commerce Platform',
            'Sistem Manajemen Kursus Online',
            'Dashboard Analitik Real-time',
            'Aplikasi Mobile Kesehatan',
            'REST API Booking Hotel',
            'Landing Page Startup',
            'Social Media App',
            'CMS Blog Modern',
        ];
 
        static $order = 1;
 
        return [
            'user_id'     => User::factory(),
            'title'       => fake()->randomElement($projects),
            'description' => fake()->paragraphs(2, true),
            'thumbnail'   => null,
            'project_url' => fake()->url(),
            'github_url'  => 'https://github.com/' . fake()->userName() . '/' . fake()->slug(),
            'type'        => fake()->randomElement(['web', 'mobile', 'design', 'other']),
            'order'       => $order++,
            'status'      => true,
        ];
    }
 
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => false,
        ]);
    }
}