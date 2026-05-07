<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::first();
 
        $portfolios = [
            [
                'title'       => 'PanduanFlow - Learning Platform',
                'description' => 'Platform belajar online modern dengan fitur kursus video, progress tracking, sertifikat otomatis, dan sistem verifikasi subscribe YouTube. Dibangun dengan Laravel & Vue.js.',
                'project_url' => 'https://panduanflow.com',
                'github_url'  => 'https://github.com/panduanflow/platform',
                'type'        => 'web',
                'order'       => 1,
            ],
            [
                'title'       => 'REST API E-Commerce',
                'description' => 'REST API lengkap untuk aplikasi e-commerce dengan fitur autentikasi, manajemen produk, cart, order, dan payment gateway integration.',
                'project_url' => null,
                'github_url'  => 'https://github.com/panduanflow/ecommerce-api',
                'type'        => 'web',
                'order'       => 2,
            ],
            [
                'title'       => 'Flutter Task Manager App',
                'description' => 'Aplikasi manajemen tugas berbasis Flutter yang berjalan di iOS dan Android. Dilengkapi fitur reminder, kategori, dan sinkronisasi cloud.',
                'project_url' => null,
                'github_url'  => 'https://github.com/panduanflow/flutter-tasks',
                'type'        => 'mobile',
                'order'       => 3,
            ],
            [
                'title'       => 'Dashboard Admin UI Kit',
                'description' => 'Desain UI Kit untuk dashboard admin yang modern, clean, dan konsisten. Dibuat menggunakan Figma dengan design system yang lengkap.',
                'project_url' => 'https://figma.com/file/example',
                'github_url'  => null,
                'type'        => 'design',
                'order'       => 4,
            ],
            [
                'title'       => 'Real-time Chat Application',
                'description' => 'Aplikasi chat real-time menggunakan Laravel Broadcasting, Pusher, dan Vue.js. Mendukung private chat, group chat, dan notifikasi push.',
                'project_url' => null,
                'github_url'  => 'https://github.com/panduanflow/chat-app',
                'type'        => 'web',
                'order'       => 5,
            ],
        ];
 
        foreach ($portfolios as $portfolio) {
            Portfolio::create(array_merge($portfolio, [
                'user_id'   => $owner->id,
                'thumbnail' => null,
                'status'    => true,
            ]));
        }
    }
}