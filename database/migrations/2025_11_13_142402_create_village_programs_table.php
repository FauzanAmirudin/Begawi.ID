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
        Schema::create('village_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')
                ->constrained('villages')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('period')->nullable();
            $table->string('lead')->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->string('status')->default('Aktif');
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->index(['village_id', 'status']);
            $table->index(['progress']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_programs');
    }
};
