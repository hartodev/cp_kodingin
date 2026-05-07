<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseChapter;
use App\Models\CourseLesson;
use App\Models\CourseLevel;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $owner    = User::first();
        $webCat   = CourseCategory::where('slug', 'web-development')->first();
        $aiCat    = CourseCategory::where('slug', 'ai-machine-learning')->first();
        $designCat = CourseCategory::where('slug', 'ui-ux-design')->first();
        $beginner  = CourseLevel::where('slug', 'beginner')->first();
        $inter     = CourseLevel::where('slug', 'intermediate')->first();
        $advanced  = CourseLevel::where('slug', 'advanced')->first();
 
        // ── Kursus 1: Laravel Fullstack ────────────────────────────
        $course1 = Course::create([
            'user_id'                   => $owner->id,
            'category_id'               => $webCat?->id,
            'course_level_id'           => $inter?->id,
            'title'                     => 'Fullstack Web Development dengan Laravel & Vue',
            'slug'                      => 'fullstack-web-development-laravel-vue',
            'seo_description'           => 'Belajar fullstack web development dengan Laravel dan Vue.js dari nol hingga deploy production.',
            'description'               => 'Kursus lengkap untuk kamu yang ingin menguasai fullstack web development menggunakan Laravel sebagai backend dan Vue.js sebagai frontend. Mulai dari setup environment, database design, REST API, hingga deploy ke VPS.',
            'demo_video_storage'        => 'youtube',
            'demo_video_source'         => 'https://www.youtube.com/watch?v=demo1',
            'duration'                  => '20 jam 30 menit',
            'certificate'               => true,
            'qna'                       => true,
            'require_youtube_subscribe' => true,
            'status'                    => 'active',
        ]);
 
        $this->createChaptersAndLessons($course1, [
            ['title' => 'Pengenalan & Setup Environment',      'lessons' => ['Instalasi Laravel', 'Setup Database & .env', 'Struktur Folder Laravel']],
            ['title' => 'Dasar-dasar Laravel',                 'lessons' => ['Routing & Controller', 'Blade Template Engine', 'Eloquent ORM Dasar']],
            ['title' => 'Autentikasi & Authorization',         'lessons' => ['Laravel Breeze Setup', 'Middleware & Gates', 'Role & Permission']],
            ['title' => 'REST API dengan Laravel',             'lessons' => ['Membuat REST API', 'API Resource & Collection', 'API Authentication Sanctum']],
            ['title' => 'Vue.js Fundamentals',                 'lessons' => ['Setup Vue.js', 'Component & Props', 'State Management Pinia']],
            ['title' => 'Integrasi Laravel & Vue.js',          'lessons' => ['Axios & API Call', 'CRUD dengan Vue.js', 'Upload File']],
            ['title' => 'Deploy ke Production',                'lessons' => ['Setup VPS & Nginx', 'Deploy Laravel', 'SSL & Domain']],
        ]);
 
        $course1->tags()->attach(Tag::whereIn('slug', ['laravel', 'vue', 'mysql', 'rest-api'])->pluck('id'));
 
        // ── Kursus 2: React JS ─────────────────────────────────────
        $course2 = Course::create([
            'user_id'                   => $owner->id,
            'category_id'               => $webCat?->id,
            'course_level_id'           => $beginner?->id,
            'title'                     => 'Belajar React JS dari Nol sampai Mahir',
            'slug'                      => 'belajar-react-js-nol-sampai-mahir',
            'seo_description'           => 'Kuasai React JS dari dasar hingga mahir. Buat project nyata yang bisa masuk portfolio.',
            'description'               => 'Kursus React JS paling lengkap untuk pemula. Kamu akan belajar component, hooks, state management, routing, dan integrasi dengan REST API. Di akhir kursus kamu akan membangun project e-commerce lengkap.',
            'demo_video_storage'        => 'youtube',
            'demo_video_source'         => 'https://www.youtube.com/watch?v=demo2',
            'duration'                  => '15 jam',
            'certificate'               => true,
            'qna'                       => true,
            'require_youtube_subscribe' => true,
            'status'                    => 'active',
        ]);
 
        $this->createChaptersAndLessons($course2, [
            ['title' => 'Pengenalan React JS',         'lessons' => ['Apa itu React?', 'Setup dengan Vite', 'JSX & Rendering']],
            ['title' => 'Component & Props',            'lessons' => ['Functional Component', 'Props & PropTypes', 'Children Component']],
            ['title' => 'State & Hooks',                'lessons' => ['useState Hook', 'useEffect Hook', 'Custom Hooks']],
            ['title' => 'React Router',                 'lessons' => ['Setup React Router', 'Dynamic Routes', 'Protected Routes']],
            ['title' => 'State Management',             'lessons' => ['Context API', 'Zustand Setup', 'Global State Pattern']],
            ['title' => 'Integrasi API',                'lessons' => ['Fetch & Axios', 'React Query', 'Error Handling']],
            ['title' => 'Project: E-Commerce App',     'lessons' => ['Setup Project', 'Product Listing', 'Cart & Checkout', 'Deploy ke Vercel']],
        ]);
 
        $course2->tags()->attach(Tag::whereIn('slug', ['react', 'javascript', 'typescript', 'rest-api'])->pluck('id'));
 
        // ── Kursus 3: AI & Machine Learning ───────────────────────
        $course3 = Course::create([
            'user_id'                   => $owner->id,
            'category_id'               => $aiCat?->id,
            'course_level_id'           => $inter?->id,
            'title'                     => 'AI & Machine Learning dengan Python',
            'slug'                      => 'ai-machine-learning-python',
            'seo_description'           => 'Belajar AI dan Machine Learning dengan Python, TensorFlow, dan scikit-learn.',
            'description'               => 'Kursus AI & Machine Learning yang membahas konsep dasar hingga implementasi model di production. Kamu akan belajar Python untuk data science, membuat model machine learning, dan deploy ke cloud.',
            'demo_video_storage'        => 'youtube',
            'demo_video_source'         => 'https://www.youtube.com/watch?v=demo3',
            'duration'                  => '18 jam',
            'certificate'               => true,
            'qna'                       => false,
            'require_youtube_subscribe' => true,
            'status'                    => 'active',
        ]);
 
        $this->createChaptersAndLessons($course3, [
            ['title' => 'Python untuk Data Science',   'lessons' => ['Setup Python & Jupyter', 'NumPy & Pandas', 'Visualisasi Data']],
            ['title' => 'Machine Learning Dasar',      'lessons' => ['Supervised Learning', 'Unsupervised Learning', 'Model Evaluation']],
            ['title' => 'Deep Learning',               'lessons' => ['Neural Network', 'TensorFlow & Keras', 'CNN & RNN']],
            ['title' => 'NLP & Computer Vision',      'lessons' => ['Text Processing', 'Sentiment Analysis', 'Object Detection']],
            ['title' => 'Deploy Model AI',             'lessons' => ['FastAPI untuk ML', 'Deploy ke Cloud', 'Monitoring Model']],
        ]);
 
        $course3->tags()->attach(Tag::whereIn('slug', ['python', 'aws'])->pluck('id'));
 
        // ── Kursus 4: UI/UX Design (draft) ────────────────────────
        Course::create([
            'user_id'                   => $owner->id,
            'category_id'               => $designCat?->id,
            'course_level_id'           => $beginner?->id,
            'title'                     => 'UI/UX Design Mastery dengan Figma',
            'slug'                      => 'uiux-design-mastery-figma',
            'seo_description'           => 'Kuasai UI/UX Design menggunakan Figma dari dasar hingga membuat prototype interaktif.',
            'description'               => 'Kursus UI/UX Design yang membahas prinsip desain, user research, wireframing, prototyping, dan design system menggunakan Figma.',
            'demo_video_storage'        => 'youtube',
            'demo_video_source'         => 'https://www.youtube.com/watch?v=demo4',
            'duration'                  => '12 jam',
            'certificate'               => true,
            'qna'                       => true,
            'require_youtube_subscribe' => true,
            'status'                    => 'draft',
        ]);
    }
 
    // ── Helper: buat chapters & lessons sekaligus ──────────────────
    private function createChaptersAndLessons(Course $course, array $chapters): void
    {
        foreach ($chapters as $chapterOrder => $chapterData) {
            $chapter = CourseChapter::create([
                'course_id' => $course->id,
                'title'     => $chapterData['title'],
                'order'     => $chapterOrder + 1,
                'status'    => true,
            ]);
 
            foreach ($chapterData['lessons'] as $lessonOrder => $lessonTitle) {
                CourseLesson::create([
                    'course_id'    => $course->id,
                    'chapter_id'   => $chapter->id,
                    'title'        => $lessonTitle,
                    'slug'         => Str::slug($lessonTitle) . '-' . $course->id . '-' . $chapterOrder . '-' . $lessonOrder,
                    'description'  => 'Pada lesson ini kamu akan belajar tentang ' . strtolower($lessonTitle) . '.',
                    'file_path'    => 'https://www.youtube.com/watch?v=' . Str::random(11),
                    'storage'      => 'youtube',
                    'file_type'    => 'video',
                    'duration'     => fake()->numerify('##') . ':' . fake()->numerify('##'),
                    'is_preview'   => $lessonOrder === 0, // lesson pertama tiap chapter bisa dipreview
                    'downloadable' => false,
                    'order'        => $lessonOrder + 1,
                    'status'       => true,
                ]);
            }
        }
    }
}