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
        Schema::create('umkm_businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('village_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Admin UMKM
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subdomain')->unique();
            $table->string('owner_name');
            $table->string('owner_email');
            $table->string('owner_phone');
            $table->string('category');
            $table->text('description')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('legal_document_path')->nullable();
            $table->enum('status', ['onboarding', 'active', 'suspended', 'inactive'])->default('onboarding');
            $table->integer('products_count')->default(0);
            $table->integer('visits_count')->default(0);
            $table->integer('orders_count')->default(0);
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_businesses');
    }
};

