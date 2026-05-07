<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $tags = [
            'Laravel', 'React', 'Vue', 'Node.js', 'Python',
            'JavaScript', 'TypeScript', 'Flutter', 'Docker',
            'MySQL', 'MongoDB', 'Redis', 'REST API', 'GraphQL',
            'Tailwind CSS', 'Bootstrap', 'Git', 'Linux', 'AWS',
        ];
 
        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        }
    }
}