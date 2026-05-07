<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $status = fake()->randomElement([
            'pending',
            'waiting_verification',
            'verified',
            'verified',     // lebih banyak yang verified
            'failed',
            'cancelled',
        ]);
 
        return [
            'invoice_id'  => 'INV-' . now()->format('Ymd') . '-' . fake()->unique()->numerify('####'),
            'user_id'     => User::factory(),
            'status'      => $status,
            'admin_note'  => $status === 'failed' ? 'Tidak ditemukan subscribe pada channel kami.' : null,
            'verified_at' => in_array($status, ['verified']) ? now() : null,
        ];
    }
 
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'      => 'pending',
            'verified_at' => null,
            'admin_note'  => null,
        ]);
    }
 
    public function waitingVerification(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'      => 'waiting_verification',
            'verified_at' => null,
            'admin_note'  => null,
        ]);
    }
 
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'      => 'verified',
            'verified_at' => now(),
            'admin_note'  => null,
        ]);
    }
 
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'      => 'failed',
            'verified_at' => now(),
            'admin_note'  => 'Tidak ditemukan subscribe pada channel kami.',
        ]);
    }
}