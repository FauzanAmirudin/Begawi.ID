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
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')
                ->nullable()
                ->constrained('websites')
                ->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->string('head')->nullable();
            $table->string('head_title')->nullable();
            $table->string('location')->nullable();
            $table->string('code')->nullable();
            $table->string('population')->nullable();
            $table->string('area')->nullable();
            $table->string('density')->nullable();
            $table->string('logo_path')->nullable();
            $table->text('description')->nullable();
            $table->text('vision')->nullable();
            $table->string('vision_period')->nullable();
            $table->json('missions')->nullable();
            $table->json('contacts')->nullable();
            $table->json('structures')->nullable();
            $table->json('history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};
