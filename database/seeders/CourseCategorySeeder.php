<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $categories = [
            ['name' => 'Web Development',       'icon' => 'fa-code'],
            ['name' => 'Mobile Development',     'icon' => 'fa-mobile-alt'],
            ['name' => 'UI/UX Design',           'icon' => 'fa-paint-brush'],
            ['name' => 'Data Science',           'icon' => 'fa-chart-bar'],
            ['name' => 'AI & Machine Learning',  'icon' => 'fa-robot'],
            ['name' => 'Cloud & DevOps',         'icon' => 'fa-cloud'],
            ['name' => 'Cybersecurity',          'icon' => 'fa-shield-alt'],
            ['name' => 'Game Development',       'icon' => 'fa-gamepad'],
        ];
 
        foreach ($categories as $category) {
            CourseCategory::create([
                'name'   => $category['name'],
                'slug'   => Str::slug($category['name']),
                'icon'   => $category['icon'],
                'status' => true,
            ]);
        }
    }
}