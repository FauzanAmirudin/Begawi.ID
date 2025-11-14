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
        Schema::create('village_potentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')
                ->constrained('villages')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('status')->default('Aktif');
            $table->string('featured_image')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->text('map_embed')->nullable();
            $table->timestamps();

            $table->index(['village_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_potentials');
    }
};
