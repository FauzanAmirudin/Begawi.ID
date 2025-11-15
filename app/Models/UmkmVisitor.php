<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UmkmVisitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_business_id',
        'ip_address',
        'user_agent',
        'referrer',
        'source',
        'source_detail',
        'page_path',
        'page_type',
        'product_id',
        'country',
        'city',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function umkmBusiness()
    {
        return $this->belongsTo(UmkmBusiness::class);
    }

    public function product()
    {
        return $this->belongsTo(UmkmProduct::class);
    }

    /**
     * Detect source from referrer
     */
    public static function detectSource(?string $referrer): array
    {
        if (empty($referrer)) {
            return ['source' => 'direct', 'source_detail' => null];
        }

        $referrer = strtolower($referrer);

        // Search engines
        if (strpos($referrer, 'google') !== false) {
            return ['source' => 'search_engine', 'source_detail' => 'google'];
        }
        if (strpos($referrer, 'bing') !== false) {
            return ['source' => 'search_engine', 'source_detail' => 'bing'];
        }
        if (strpos($referrer, 'yahoo') !== false) {
            return ['source' => 'search_engine', 'source_detail' => 'yahoo'];
        }
        if (strpos($referrer, 'yandex') !== false) {
            return ['source' => 'search_engine', 'source_detail' => 'yandex'];
        }

        // Social media
        if (strpos($referrer, 'facebook') !== false) {
            return ['source' => 'social_media', 'source_detail' => 'facebook'];
        }
        if (strpos($referrer, 'instagram') !== false) {
            return ['source' => 'social_media', 'source_detail' => 'instagram'];
        }
        if (strpos($referrer, 'twitter') !== false || strpos($referrer, 'x.com') !== false) {
            return ['source' => 'social_media', 'source_detail' => 'twitter'];
        }
        if (strpos($referrer, 'tiktok') !== false) {
            return ['source' => 'social_media', 'source_detail' => 'tiktok'];
        }
        if (strpos($referrer, 'linkedin') !== false) {
            return ['source' => 'social_media', 'source_detail' => 'linkedin'];
        }
        if (strpos($referrer, 'whatsapp') !== false) {
            return ['source' => 'social_media', 'source_detail' => 'whatsapp'];
        }
        if (strpos($referrer, 'youtube') !== false) {
            return ['source' => 'social_media', 'source_detail' => 'youtube'];
        }

        // Other referrals
        return ['source' => 'referral', 'source_detail' => parse_url($referrer, PHP_URL_HOST)];
    }
}
