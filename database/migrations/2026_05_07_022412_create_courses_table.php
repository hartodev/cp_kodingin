<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('course_categories')->nullOnDelete();
            $table->foreignId('course_level_id')->nullable()->constrained('course_levels')->nullOnDelete();
 
            // Informasi utama
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('seo_description')->nullable();
            $table->text('description')->nullable();
 
            // Media
            $table->string('thumbnail')->nullable();
            $table->enum('demo_video_storage', ['upload', 'youtube', 'vimeo', 'external_link'])->nullable();
            $table->text('demo_video_source')->nullable();
 
            // Detail kursus
            $table->string('duration')->nullable();     // contoh: 10 jam 30 menit
            $table->boolean('certificate')->default(false);
            $table->boolean('qna')->default(false);
 
            // Syarat akses — harus subscribe YouTube
            $table->boolean('require_youtube_subscribe')->default(true);
 
            // Status
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft')->index();
 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};