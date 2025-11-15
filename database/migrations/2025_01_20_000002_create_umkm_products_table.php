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
        Schema::create('umkm_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_business_id')->constrained('umkm_businesses')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('umkm_product_categories')->onDelete('set null');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->enum('availability_status', ['ready', 'pre_order'])->default('ready');
            $table->json('labels')->nullable(); // ['best_seller', 'new', 'promo']
            $table->json('variants')->nullable(); // JSON untuk varian produk
            $table->string('weight')->nullable();
            $table->string('dimension')->nullable();
            $table->integer('sold_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['umkm_business_id', 'slug']);
            $table->index(['umkm_business_id', 'is_active']);
            $table->index(['category_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_products');
    }
};

