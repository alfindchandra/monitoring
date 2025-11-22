<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ormawa_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Album/Category
            $table->string('album')->nullable(); // Nama album/kategori
            
            // Photo Info
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('path'); // Path file foto
            $table->string('thumbnail_path')->nullable(); // Path thumbnail
            
            // Metadata
            $table->string('photographer')->nullable(); // Nama fotografer
            $table->date('taken_date')->nullable(); // Tanggal pengambilan foto
            $table->string('location')->nullable(); // Lokasi pengambilan
            
            // Settings
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_public')->default(true);
            $table->integer('order')->default(0); // Urutan dalam album
            
            // Engagement
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index('album');
            $table->index('is_public');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};