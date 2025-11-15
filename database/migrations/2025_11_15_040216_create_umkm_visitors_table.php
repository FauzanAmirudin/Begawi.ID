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
        Schema::create('umkm_visitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_business_id')->constrained('umkm_businesses')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->string('source')->nullable(); // direct, search_engine, social_media, referral
            $table->string('source_detail')->nullable(); // google, facebook, instagram, etc.
            $table->string('page_path')->nullable(); // /product, /about, etc.
            $table->string('page_type')->nullable(); // home, product, product_detail, about
            $table->foreignId('product_id')->nullable()->constrained('umkm_products')->onDelete('set null');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->timestamp('visited_at');
            $table->timestamps();

            $table->index(['umkm_business_id', 'visited_at']);
            $table->index(['source', 'visited_at']);
            $table->index(['page_type', 'visited_at']);
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_visitors');
    }
};
