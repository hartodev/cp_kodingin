<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $testimonials = [
            [
                'name'   => 'Budi Santoso',
                'title'  => 'Web Developer at Tokopedia',
                'review' => 'PanduanFlow benar-benar mengubah karir saya. Dari tidak tahu coding sama sekali, sekarang sudah kerja sebagai web developer di perusahaan impian.',
                'rating' => 5,
                'order'  => 1,
            ],
            [
                'name'   => 'Sari Dewi',
                'title'  => 'Frontend Developer - Freelance',
                'review' => 'Materi yang disajikan sangat terstruktur dan mudah dipahami. Dalam 3 bulan saya berhasil membangun portfolio yang kuat dan mendapat klien pertama saya.',
                'rating' => 5,
                'order'  => 2,
            ],
            [
                'name'   => 'Andi Pratama',
                'title'  => 'Full Stack Developer at Startup',
                'review' => 'Kursusnya lengkap banget dari dasar sampai deploy. Project-nya langsung bisa masuk portfolio. Gak perlu beli kursus di tempat lain lagi!',
                'rating' => 5,
                'order'  => 3,
            ],
            [
                'name'   => 'Rina Kusuma',
                'title'  => 'UI/UX Designer',
                'review' => 'Sebagai desainer yang mau belajar coding, PanduanFlow sangat membantu. Penjelasannya tidak bikin pusing dan langsung praktik.',
                'rating' => 5,
                'order'  => 4,
            ],
            [
                'name'   => 'Dian Permana',
                'title'  => 'Mobile Developer at Gojek',
                'review' => 'Kursus Flutter di PanduanFlow terbaik yang pernah saya ikuti. Dari nol sekarang sudah kerja di Gojek sebagai mobile developer.',
                'rating' => 5,
                'order'  => 5,
            ],
            [
                'name'   => 'Fajar Nugroho',
                'title'  => 'Backend Developer',
                'review' => 'Sistem belajarnya keren! Hanya dengan subscribe YouTube sudah bisa akses semua kursus. Sangat worth it untuk developer pemula.',
                'rating' => 4,
                'order'  => 6,
            ],
        ];
 
        foreach ($testimonials as $testimonial) {
            Testimonial::create(array_merge($testimonial, [
                'image'  => null,
                'status' => true,
            ]));
        }
    }

}