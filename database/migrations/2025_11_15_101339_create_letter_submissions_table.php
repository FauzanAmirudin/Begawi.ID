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
        Schema::create('letter_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            $table->foreignId('village_id')->constrained('villages')->onDelete('cascade');
            $table->string('letter_type'); // ktp, domisili, usaha, tidak-mampu, belum-menikah, kelahiran
            $table->string('nama');
            $table->string('nik');
            $table->string('telepon');
            $table->string('email')->nullable();
            $table->text('alamat');
            $table->text('keperluan');
            $table->json('requirements_files')->nullable(); // Array of file paths
            $table->enum('status', ['pending', 'verified', 'processed', 'completed', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->string('completed_file_path')->nullable(); // Path to completed letter PDF
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
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
        Schema::dropIfExists('letter_submissions');
    }
};
