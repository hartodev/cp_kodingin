<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\YoutubeVerification>
 */
class YoutubeVerificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $status = fake()->randomElement(['pending', 'approved', 'approved', 'rejected']);
 
        return [
            'user_id'              => User::factory(),
            'order_id'             => Order::factory(),
            'proof_image'          => null,
            'youtube_channel_name' => fake()->name() . ' Channel',
            'youtube_channel_url'  => 'https://youtube.com/@' . fake()->userName(),
            'status'               => $status,
            'admin_note'           => $status === 'rejected' ? 'Subscribe tidak ditemukan, coba lagi.' : null,
            'verified_by'          => in_array($status, ['approved', 'rejected']) ? 1 : null,
            'verified_at'          => in_array($status, ['approved', 'rejected']) ? now() : null,
        ];
    }
 
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'      => 'pending',
            'admin_note'  => null,
            'verified_by' => null,
            'verified_at' => null,
        ]);
    }
 
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'      => 'approved',
            'verified_by' => 1,
            'verified_at' => now(),
            'admin_note'  => null,
        ]);
    }
 
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'      => 'rejected',
            'verified_by' => 1,
            'verified_at' => now(),
            'admin_note'  => 'Subscribe tidak ditemukan pada channel kami.',
        ]);
    }
}