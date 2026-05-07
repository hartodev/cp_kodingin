<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $positiveReviews = [
            'Kursus ini sangat bagus dan mudah dipahami. Sangat recommended!',
            'Penjelasan sangat detail dan terstruktur. Saya belajar banyak dari kursus ini.',
            'Materi lengkap, mentor menjelaskan dengan sabar dan jelas.',
            'Sangat worth it! Dari nol sekarang sudah bisa buat project sendiri.',
            'Konten berkualitas, project langsung bisa dipakai di dunia kerja.',
        ];
 
        $averageReviews = [
            'Cukup bagus, tapi ada beberapa bagian yang penjelasannya kurang detail.',
            'Materi sudah lumayan, namun harapannya ada update untuk tools terbaru.',
            'Overall bagus, tapi kecepatan menjelaskan terlalu cepat di beberapa bagian.',
        ];
 
        $rating  = fake()->numberBetween(3, 5);
        $reviews = $rating >= 4 ? $positiveReviews : $averageReviews;
 
        return [
            'user_id'   => User::factory(),
            'course_id' => Course::factory(),
            'review'    => fake()->randomElement($reviews),
            'rating'    => $rating,
            'status'    => true,
        ];
    }
 
    public function highRating(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(4, 5),
        ]);
    }
 
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => false,
        ]);
    }
}