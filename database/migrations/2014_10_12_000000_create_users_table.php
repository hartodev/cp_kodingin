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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
 
            // Profile
            $table->string('image')->default('/default-files/avatar.png');
            $table->string('headline')->nullable();
            $table->text('bio')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
 
            // Social links
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('x')->nullable();
            $table->string('website')->nullable();
 
            // YouTube — untuk verifikasi subscribe
            $table->string('youtube_channel_id')->nullable();   // channel ID user (opsional)
            $table->boolean('is_youtube_verified')->default(false)->index(); // sudah pernah verifikasi
 
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};