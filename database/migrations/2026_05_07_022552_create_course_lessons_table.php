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
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('chapter_id')->constrained('course_chapters')->onDelete('cascade');
 
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
 
            // Sumber materi
            $table->text('file_path')->nullable();
            $table->enum('storage', ['upload', 'youtube', 'vimeo', 'external_link'])->default('youtube');
            $table->enum('file_type', ['video', 'audio', 'pdf', 'doc', 'file'])->default('video');
            $table->string('duration')->nullable();     // contoh: 12:34
            $table->string('volume')->nullable();       // ukuran file
 
            // Pengaturan
            $table->boolean('is_preview')->default(false);  // bisa ditonton tanpa enroll
            $table->boolean('downloadable')->default(false);
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};