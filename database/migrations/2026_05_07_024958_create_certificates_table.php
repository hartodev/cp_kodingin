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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
 
            $table->string('certificate_number')->unique(); // contoh: CERT-2024-00001
            $table->string('file_path')->nullable();        // path file PDF sertifikat
            $table->timestamp('issued_at')->nullable();     // tanggal diterbitkan
 
            $table->timestamps();
 
            // Satu user hanya punya satu sertifikat per kursus
            $table->unique(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};