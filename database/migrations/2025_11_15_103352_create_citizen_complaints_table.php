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
        Schema::create('citizen_complaints', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            $table->foreignId('village_id')->constrained('villages')->onDelete('cascade');
            $table->string('nama');
            $table->string('telepon');
            $table->string('email')->nullable();
            $table->string('kategori'); // pelayanan-umum, infrastruktur, sosial, keamanan
            $table->string('lokasi')->nullable();
            $table->string('judul');
            $table->text('deskripsi');
            $table->json('bukti_files')->nullable(); // Array of file paths
            $table->boolean('is_anonymous')->default(false);
            $table->enum('status', ['pending', 'reviewed', 'in_progress', 'resolved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('in_progress_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizen_complaints');
    }
};
