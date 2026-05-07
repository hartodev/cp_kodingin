<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {  return [
            'name'                => fake()->name(),
            'email'               => fake()->unique()->safeEmail(),
            'password'            => Hash::make('password'),
            'role'                => 'user',            // ← tambah ini
            'image'               => '/default-files/avatar.png',
            'headline'            => fake()->jobTitle(),
            'bio'                 => fake()->paragraph(),
            'gender'              => fake()->randomElement(['male', 'female']),
            'github'              => 'https://github.com/' . fake()->userName(),
            'linkedin'            => 'https://linkedin.com/in/' . fake()->userName(),
            'instagram'           => 'https://instagram.com/' . fake()->userName(),
            'facebook'            => null,
            'x'                   => null,
            'website'             => fake()->url(),
            'youtube_channel_id'  => null,
            'is_youtube_verified' => fake()->boolean(70),
            'email_verified_at'   => now(),
            'remember_token'      => Str::random(10),
        ];
    }
 
    // ── State: belum verifikasi email ──────────────────────────────
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
 
    // ── State: sudah subscribe YouTube ────────────────────────────
    public function youtubeVerified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_youtube_verified' => true,
            'youtube_channel_id'  => 'UC' . Str::random(22),
        ]);
    }
 
    // ── State: belum subscribe YouTube ────────────────────────────
    public function youtubeUnverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_youtube_verified' => false,
            'youtube_channel_id'  => null,
        ]);
    }
}