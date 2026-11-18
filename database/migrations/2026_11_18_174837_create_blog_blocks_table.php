<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained('blogs')->cascadeOnDelete();
            $table->enum('type', ['text', 'image']);
            $table->longText('content')->nullable();   // isi teks
            $table->string('image')->nullable();       // path gambar
            $table->string('caption')->nullable();     // keterangan gambar (opsional)
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['blog_id', 'sort_order']);
        });

        // Pindahkan konten blog lama (kolom description) menjadi 1 blok teks,
        // supaya blog yang sudah ada tetap tampil dan bisa diedit.
        DB::table('blogs')->orderBy('id')->each(function ($blog) {
            if (trim((string) $blog->description) === '') {
                return;
            }

            DB::table('blog_blocks')->insert([
                'blog_id'    => $blog->id,
                'type'       => 'text',
                'content'    => $blog->description,
                'sort_order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_blocks');
    }
};
