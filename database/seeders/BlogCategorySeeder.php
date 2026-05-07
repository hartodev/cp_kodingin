<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $categories = ['Tutorial', 'Tips & Tricks', 'Panduan', 'Review Tools', 'Karir Developer', 'News & Update'];
 
        foreach ($categories as $name) {
            BlogCategory::create([
                'name'   => $name,
                'slug'   => Str::slug($name),
                'status' => true,
            ]);
        }
    }
}
 