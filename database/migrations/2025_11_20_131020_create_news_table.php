<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ormawa_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Content
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Ringkasan singkat
            $table->longText('content');
            
            // Media
            $table->string('featured_image')->nullable(); // Foto utama
            
            // SEO & Metadata
            $table->string('author')->nullable(); // Nama penulis
            $table->enum('category', [
                'prestasi',
                'kegiatan',
                'pengumuman',
                'opini',
                'liputan',
                'lainnya'
            ])->default('kegiatan');
            
            // Status & Visibility
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false); // Berita unggulan
            $table->timestamp('published_at')->nullable();
            
            // Engagement
            $table->integer('views_count')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
