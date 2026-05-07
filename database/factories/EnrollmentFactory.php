<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'course_id'   => Course::factory(),
            'order_id'    => Order::factory()->verified(),
            'have_access' => true,
            'enrolled_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
 
    // ── State: akses dicabut ──────────────────────────────────────
    public function revoked(): static
    {
        return $this->state(fn (array $attributes) => [
            'have_access' => false,
        ]);
    }
}