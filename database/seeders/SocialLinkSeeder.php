<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $links = [
            ['platform' => 'YouTube',    'icon' => 'fa-youtube',    'url' => 'https://youtube.com/@KodinginYuk',           'order' => 1],
            ['platform' => 'Instagram',  'icon' => 'fa-instagram',  'url' => 'https://instagram.com/KodinginYuk',          'order' => 2],
            ['platform' => 'GitHub',     'icon' => 'fa-github',     'url' => 'https://github.com/KodinginYuk',             'order' => 3],
            ['platform' => 'LinkedIn',   'icon' => 'fa-linkedin',   'url' => 'https://linkedin.com/in/KodinginYuk',        'order' => 4],
            ['platform' => 'X/Twitter',  'icon' => 'fa-x-twitter',  'url' => 'https://x.com/KodinginYuk',                 'order' => 5],
        ];

        foreach ($links as $link) {
            SocialLink::create(array_merge($link, ['status' => true]));
        }
    }
}
