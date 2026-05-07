<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogComment>
 */
class BlogCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comments = [
            'Artikel yang sangat bermanfaat, terima kasih sudah berbagi!',
            'Penjelasannya mudah dipahami, langsung bisa dipraktikkan.',
            'Boleh minta referensi tambahan untuk belajar lebih lanjut?',
            'Saya sudah coba dan berhasil. Sangat membantu sekali!',
            'Konten keren! Ditunggu artikel selanjutnya.',
            'Baru tahu tips ini, langsung saya coba. Mantap!',
        ];
 
        return [
            'user_id' => User::factory(),
            'blog_id' => Blog::factory(),
            'comment' => fake()->randomElement($comments),
            'status'  => true,
        ];
    }
}