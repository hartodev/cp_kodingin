<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $faqs = [
            [
                'question' => 'Bagaimana cara mengakses kursus?',
                'answer'   => 'Caranya mudah! Tambahkan kursus ke cart → checkout → subscribe channel YouTube kami → upload bukti subscribe → tunggu verifikasi admin (max 1x24 jam) → akses kursus langsung terbuka.',
            ],
            [
                'question' => 'Berapa lama proses verifikasi subscribe?',
                'answer'   => 'Proses verifikasi biasanya membutuhkan waktu maksimal 1x24 jam pada hari kerja. Kamu akan mendapat notifikasi di dashboard dan email setelah verifikasi selesai.',
            ],
            [
                'question' => 'Apakah sertifikat berlaku seumur hidup?',
                'answer'   => 'Ya! Sertifikat yang kamu dapatkan setelah menyelesaikan 100% materi kursus berlaku seumur hidup dan bisa diunduh kapan saja dalam format PDF.',
            ],
            [
                'question' => 'Apakah ada batas waktu untuk menyelesaikan kursus?',
                'answer'   => 'Tidak ada batas waktu sama sekali. Setelah akses dibuka, kamu bisa belajar sesuai dengan pace kamu sendiri, kapan saja dan di mana saja.',
            ],
            [
                'question' => 'Apa yang terjadi jika saya unsubscribe dari YouTube?',
                'answer'   => 'Syarat utama untuk menjaga akses kursus adalah tetap subscribe channel YouTube kami. Jika unsubscribe, akses kursus bisa dicabut. Pastikan kamu tetap subscribe ya!',
            ],
            [
                'question' => 'Bisakah saya mengakses kursus dari perangkat berbeda?',
                'answer'   => 'Ya, kamu bisa mengakses kursus dari perangkat apapun (laptop, tablet, smartphone) menggunakan akun yang sama. Tidak ada batasan perangkat.',
            ],
            [
                'question' => 'Bagaimana jika verifikasi saya ditolak?',
                'answer'   => 'Jika verifikasi ditolak, kamu akan mendapat notifikasi beserta alasannya. Pastikan kamu benar-benar sudah subscribe channel YouTube kami, kemudian ajukan verifikasi ulang.',
            ],
            [
                'question' => 'Apakah bisa diskusi dengan mentor?',
                'answer'   => 'Ya! Setiap kursus yang mengaktifkan fitur QnA memiliki forum diskusi. Kamu bisa bertanya langsung dan mendapat jawaban dari mentor maupun sesama student.',
            ],
        ];
 
        foreach ($faqs as $index => $faq) {
            Faq::create(array_merge($faq, [
                'order'  => $index + 1,
                'status' => true,
            ]));
        }
    
    }
}