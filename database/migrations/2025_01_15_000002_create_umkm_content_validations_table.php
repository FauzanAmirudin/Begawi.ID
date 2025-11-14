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
        Schema::create('umkm_content_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_business_id')->constrained('umkm_businesses')->onDelete('cascade');
            $table->foreignId('submitted_by')->constrained('users')->onDelete('cascade');
            $table->enum('content_type', ['product', 'photo', 'promotion', 'profile_update']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('content_data')->nullable(); // Store product details, image paths, etc.
            $table->enum('status', ['draft', 'review', 'verification', 'approved', 'rejected', 'revision_requested'])->default('review');
            $table->text('rejection_reason')->nullable();
            $table->text('revision_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_content_validations');
    }
};

