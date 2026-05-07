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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
 
            $table->boolean('have_access')->default(true)->index(); // bisa dicabut admin
            $table->timestamp('enrolled_at')->nullable();           // waktu akses dibuka
 
            $table->timestamps();
 
            // Satu user hanya bisa enroll kursus yang sama sekali
            $table->unique(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};