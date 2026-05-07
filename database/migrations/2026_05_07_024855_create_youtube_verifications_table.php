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
        Schema::create('youtube_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
 
            // Screenshot bukti subscribe yang diupload user (opsional tapi disarankan)
            $table->string('proof_image')->nullable();
 
            // Nama/URL channel YouTube user (diisi manual oleh user)
            $table->string('youtube_channel_name')->nullable();
            $table->string('youtube_channel_url')->nullable();
 
            // Status verifikasi
            $table->enum('status', [
                'pending',   // user sudah klaim, menunggu admin cek
                'approved',  // admin konfirmasi subscribe → trigger buka akses
                'rejected',  // admin tolak → user diminta subscribe ulang
            ])->default('pending')->index();
 
            // Catatan admin saat approve/reject
            $table->text('admin_note')->nullable();
 
            // Siapa admin yang verifikasi dan kapan
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_verifications');
    }
};