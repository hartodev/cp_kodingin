<?php

namespace Database\Seeders;

use App\Models\CourseLesson;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use Illuminate\Database\Seeder;

class LessonProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    // Ambil semua enrollment yang aktif
        $enrollments = Enrollment::where('have_access', true)->get();
 
        foreach ($enrollments as $enrollment) {
            $lessons = CourseLesson::where('course_id', $enrollment->course_id)
                ->where('status', true)
                ->get();
 
            // Simulasi progress: tiap user punya progress berbeda-beda
            $progressRate = fake()->randomElement([0.25, 0.50, 0.75, 1.0]); // 25%, 50%, 75%, 100%
            $lessonsToComplete = (int) ceil($lessons->count() * $progressRate);
 
            foreach ($lessons->take($lessonsToComplete) as $index => $lesson) {
                // Skip jika sudah ada progress
                if (LessonProgress::where('user_id', $enrollment->user_id)->where('lesson_id', $lesson->id)->exists()) {
                    continue;
                }
 
                LessonProgress::create([
                    'user_id'         => $enrollment->user_id,
                    'course_id'       => $enrollment->course_id,
                    'lesson_id'       => $lesson->id,
                    'is_completed'    => true,
                    'watched_seconds' => fake()->numberBetween(300, 3600),
                ]);
            }
        }
    }
}