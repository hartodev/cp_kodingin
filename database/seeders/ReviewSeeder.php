<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hanya user yang sudah enroll yang bisa review
        $enrollments = Enrollment::where('have_access', true)
            ->inRandomOrder()
            ->limit(40)
            ->get();
 
        $reviews = [
            ['rating' => 5, 'text' => 'Kursus ini sangat bagus dan mudah dipahami. Sangat recommended!'],
            ['rating' => 5, 'text' => 'Penjelasan sangat detail dan terstruktur. Saya belajar banyak dari kursus ini.'],
            ['rating' => 5, 'text' => 'Materi lengkap, penjelasan sangat jelas. Dari nol sekarang sudah bisa buat project sendiri.'],
            ['rating' => 4, 'text' => 'Cukup bagus, tapi ada beberapa bagian yang penjelasannya kurang detail.'],
            ['rating' => 4, 'text' => 'Materi sudah bagus, harapannya ada update untuk tools terbaru.'],
            ['rating' => 5, 'text' => 'Sangat worth it! Konten berkualitas dan project-nya langsung bisa dipakai di dunia kerja.'],
            ['rating' => 3, 'text' => 'Overall bagus, tapi kecepatan menjelaskan terlalu cepat di beberapa bagian.'],
        ];
 
        foreach ($enrollments as $enrollment) {
            // Skip jika sudah pernah review
            if (Review::where('user_id', $enrollment->user_id)->where('course_id', $enrollment->course_id)->exists()) {
                continue;
            }
 
            $review = fake()->randomElement($reviews);
 
            Review::create([
                'user_id'   => $enrollment->user_id,
                'course_id' => $enrollment->course_id,
                'review'    => $review['text'],
                'rating'    => $review['rating'],
                'status'    => true,
            ]);
        }
    }
}