<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $owner    = User::first();
        $tutorial = BlogCategory::where('slug', 'tutorial')->first();
        $tips     = BlogCategory::where('slug', 'tips-tricks')->first();
        $panduan  = BlogCategory::where('slug', 'panduan')->first();
        $karir    = BlogCategory::where('slug', 'karir-developer')->first();
 
        $blogs = [
            [
                'category'    => $tutorial,
                'title'       => 'Panduan Lengkap Belajar Laravel untuk Pemula',
                'description' => 'Laravel adalah framework PHP yang paling populer saat ini. Dalam panduan ini kita akan belajar Laravel dari nol, mulai dari instalasi, routing, controller, model, hingga membuat CRUD sederhana. Cocok untuk kamu yang baru belajar web development.',
            ],
            [
                'category'    => $tips,
                'title'       => '10 Tips Menjadi Developer Produktif di 2024',
                'description' => 'Produktivitas adalah kunci sukses seorang developer. Dalam artikel ini saya akan berbagi 10 tips yang sudah saya praktikkan sendiri untuk meningkatkan produktivitas coding sehari-hari. Mulai dari tools, workflow, hingga kebiasaan sehat.',
            ],
            [
                'category'    => $panduan,
                'title'       => 'Cara Deploy Aplikasi Laravel ke VPS dengan Nginx',
                'description' => 'Setelah aplikasi Laravel kamu selesai dibuat, langkah selanjutnya adalah deploy ke server production. Dalam panduan ini kita akan belajar cara setup VPS, install Nginx, PHP, MySQL, dan deploy aplikasi Laravel secara lengkap.',
            ],
            [
                'category'    => $karir,
                'title'       => 'Roadmap Belajar Full Stack Developer 2024',
                'description' => 'Ingin menjadi full stack developer tapi bingung harus belajar apa dulu? Artikel ini akan membahas roadmap lengkap yang bisa kamu ikuti, dari HTML/CSS dasar hingga deployment dan DevOps. Disertai rekomendasi sumber belajar terbaik.',
            ],
            [
                'category'    => $tutorial,
                'title'       => 'Belajar React JS: Dari useState hingga Redux Toolkit',
                'description' => 'State management adalah salah satu konsep paling penting dalam React. Artikel ini membahas perjalanan dari useState sederhana, Context API, hingga menggunakan Redux Toolkit untuk aplikasi skala besar.',
            ],
            [
                'category'    => $tips,
                'title'       => 'Git Workflow untuk Tim Developer yang Efektif',
                'description' => 'Bekerja dalam tim membutuhkan workflow Git yang baik agar tidak ada konflik dan kode tetap terjaga kualitasnya. Kita akan bahas Git Flow, feature branching, pull request, hingga code review yang efektif.',
            ],
        ];
 
        foreach ($blogs as $index => $blogData) {
            Blog::create([
                'user_id'          => $owner->id,
                'blog_category_id' => $blogData['category']?->id ?? BlogCategory::first()->id,
                'title'            => $blogData['title'],
                'slug'             => Str::slug($blogData['title']),
                'image'            => null,
                'description'      => $blogData['description'],
                'seo_description'  => Str::limit($blogData['description'], 155),
                'status'           => true,
            ]);
        }
    }
}