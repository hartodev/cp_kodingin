<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reviews = [
            'PanduanFlow benar-benar mengubah karir saya. Dari tidak tahu coding sama sekali, sekarang sudah kerja sebagai developer.',
            'Materi yang disajikan sangat terstruktur dan mudah dipahami. Mentor juga sangat responsif di forum diskusi.',
            'Saya sudah coba banyak platform belajar, PanduanFlow yang paling worth it. Project-nya langsung bisa masuk portfolio.',
            'Dalam 3 bulan belajar di PanduanFlow, saya berhasil dapat pekerjaan pertama saya sebagai web developer.',
            'Kursusnya lengkap banget dari dasar sampai deploy. Gak perlu beli kursus di tempat lain lagi.',
        ];
 
        $titles = [
            'Web Developer', 'Frontend Developer', 'Full Stack Developer',
            'Mobile Developer', 'UI/UX Designer', 'Backend Developer',
        ];
 
        static $order = 1;
 
        return [
            'name'   => fake()->name(),
            'title'  => fake()->randomElement($titles),
            'image'  => null,
            'review' => fake()->randomElement($reviews),
            'rating' => fake()->numberBetween(4, 5),
            'order'  => $order++,
            'status' => true,
        ];
    }
}