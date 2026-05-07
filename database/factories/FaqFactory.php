<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $faqs = [
            [
                'question' => 'Bagaimana cara mengakses kursus setelah checkout?',
                'answer'   => 'Setelah checkout, kamu perlu subscribe channel YouTube kami. Setelah admin memverifikasi subscribe kamu, akses kursus akan langsung terbuka di dashboard.',
            ],
            [
                'question' => 'Berapa lama proses verifikasi subscribe?',
                'answer'   => 'Proses verifikasi biasanya membutuhkan waktu 1x24 jam pada hari kerja. Kamu akan mendapat notifikasi setelah verifikasi selesai.',
            ],
            [
                'question' => 'Apakah sertifikat berlaku seumur hidup?',
                'answer'   => 'Ya, sertifikat yang kamu dapatkan setelah menyelesaikan kursus berlaku seumur hidup dan bisa diunduh kapan saja.',
            ],
            [
                'question' => 'Apakah ada batas waktu untuk menyelesaikan kursus?',
                'answer'   => 'Tidak ada batas waktu. Setelah akses dibuka, kamu bisa belajar sesuai dengan pace kamu sendiri.',
            ],
            [
                'question' => 'Apa yang terjadi jika saya unsubscribe dari YouTube?',
                'answer'   => 'Akses kursus bisa dicabut jika kamu unsubscribe dari channel YouTube kami. Pastikan kamu tetap subscribe untuk menjaga akses kursus.',
            ],
            [
                'question' => 'Bisakah saya mengakses kursus dari perangkat berbeda?',
                'answer'   => 'Ya, kamu bisa mengakses kursus dari perangkat apapun menggunakan akun yang sama.',
            ],
        ];
 
        static $index = 0;
        $faq = $faqs[$index % count($faqs)];
        $index++;
 
        return [
            'question' => $faq['question'],
            'answer'   => $faq['answer'],
            'order'    => $index,
            'status'   => true,
        ];
    }
}