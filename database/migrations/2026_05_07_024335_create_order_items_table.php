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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
             $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
 
            // Snapshot data kursus saat checkout
            // (jaga-jaga kalau judul kursus diubah setelah checkout)
            $table->string('course_title');
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};