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
        Schema::create('village_agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')
                ->constrained('villages')
                ->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->time('time');
            $table->string('location');
            $table->enum('category', ['Rapat', 'Pelatihan', 'Acara', 'Kesehatan'])->default('Acara');
            $table->json('timeline')->nullable();
            $table->json('checklist')->nullable();
            $table->json('organizers')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['village_id', 'date']);
            $table->index(['is_published', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_agendas');
    }
};
