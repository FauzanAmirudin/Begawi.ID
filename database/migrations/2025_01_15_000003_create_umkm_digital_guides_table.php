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
        Schema::create('umkm_digital_guides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('category', ['tips', 'pelatihan', 'artikel', 'video', 'template']);
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable(); // pdf, ppt, zip, video
            $table->string('external_link')->nullable(); // For Zoom, YouTube, etc.
            $table->integer('duration_minutes')->nullable();
            $table->boolean('is_published')->default(true);
            $table->boolean('notify_all_umkm')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_digital_guides');
    }
};

