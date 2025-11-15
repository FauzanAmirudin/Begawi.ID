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
        Schema::table('umkm_businesses', function (Blueprint $table) {
            // Informasi Umum
            $table->string('whatsapp_number')->nullable()->after('owner_phone');
            $table->text('address')->nullable()->after('whatsapp_number');
            $table->text('maps_embed_url')->nullable()->after('address');
            
            // Identitas Visual
            $table->string('banner_path')->nullable()->after('logo_path');
            $table->string('branding_color')->nullable()->after('banner_path');
            
            // Jam Operasional (JSON format)
            $table->json('operating_hours')->nullable()->after('branding_color');
            
            // Sosial Media (JSON format)
            $table->json('social_media')->nullable()->after('operating_hours');
            
            // Tentang Usaha (extended description)
            $table->text('about_business')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm_businesses', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp_number',
                'address',
                'maps_embed_url',
                'banner_path',
                'branding_color',
                'operating_hours',
                'social_media',
                'about_business',
            ]);
        });
    }
};
