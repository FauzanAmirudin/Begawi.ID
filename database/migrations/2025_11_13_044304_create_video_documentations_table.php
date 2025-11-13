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
        Schema::create('video_documentations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['youtube', 'pdf'])->default('youtube');
            $table->string('youtube_url')->nullable(); // YouTube embed URL
            $table->string('pdf_file')->nullable(); // PDF file path
            $table->string('thumbnail')->nullable();
            $table->integer('duration')->nullable(); // Duration in seconds (for videos)
            $table->integer('views')->default(0);
            $table->boolean('is_published')->default(false);
            $table->integer('sort_order')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_documentations');
    }
};
