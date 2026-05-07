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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->unique();  // contoh: INV-20240101-0001
 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
 
            // Status alur checkout
            $table->enum('status', [
                'pending',              // baru checkout, belum subscribe
                'waiting_verification', // sudah klaim subscribe, menunggu verifikasi admin
                'verified',             // admin konfirmasi sudah subscribe → akses dibuka
                'failed',               // verifikasi gagal / tidak subscribe
                'cancelled',            // dibatalkan user
            ])->default('pending')->index();
 
            // Catatan dari admin saat verifikasi
            $table->text('admin_note')->nullable();
 
            // Waktu verifikasi
            $table->timestamp('verified_at')->nullable();
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};