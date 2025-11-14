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
        Schema::create('village_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')
                ->constrained('villages')
                ->cascadeOnDelete();
            $table->string('title');
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('category')->nullable();
            $table->string('organizer')->nullable();
            $table->text('description')->nullable();
            $table->string('attachment_path')->nullable();
            $table->timestamps();

            $table->index(['village_id', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_achievements');
    }
};
