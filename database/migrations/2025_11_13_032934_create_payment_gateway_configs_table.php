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
        Schema::create('payment_gateway_configs', function (Blueprint $table) {
            $table->id();
            $table->enum('gateway', ['midtrans', 'xendit'])->unique();
            $table->string('environment')->default('sandbox'); // sandbox or production
            $table->string('server_key')->nullable();
            $table->string('client_key')->nullable();
            $table->string('api_key')->nullable();
            $table->string('secret_key')->nullable();
            $table->boolean('is_active')->default(false);
            $table->json('additional_config')->nullable(); // For extra settings
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_configs');
    }
};
