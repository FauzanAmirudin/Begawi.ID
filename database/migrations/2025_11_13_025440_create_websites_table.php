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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['desa', 'umkm'])->default('desa');
            $table->string('url')->unique(); // subdomain atau domain
            $table->string('custom_domain')->nullable();
            $table->enum('status', ['active', 'suspended', 'inactive'])->default('active');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('template_id')->nullable();
            $table->enum('dns_status', ['pending', 'active', 'failed'])->nullable();
            $table->timestamp('domain_expires_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
