<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmBusiness extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'village_id',
        'user_id',
        'name',
        'slug',
        'subdomain',
        'owner_name',
        'owner_email',
        'owner_phone',
        'whatsapp_number',
        'address',
        'maps_embed_url',
        'category',
        'description',
        'about_business',
        'logo_path',
        'banner_path',
        'branding_color',
        'operating_hours',
        'social_media',
        'legal_document_path',
        'status',
        'products_count',
        'visits_count',
        'orders_count',
        'last_activity_at',
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
        'operating_hours' => 'array',
        'social_media' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function products()
    {
        return $this->hasMany(UmkmProduct::class);
    }

    public function categories()
    {
        return $this->hasMany(UmkmProductCategory::class);
    }

    public function contentValidations()
    {
        return $this->hasMany(UmkmContentValidation::class, 'umkm_business_id');
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Aktif',
            'onboarding' => 'Onboarding',
            'suspended' => 'Ditangguhkan',
            'inactive' => 'Tidak Aktif',
            default => ucfirst($this->status ?? 'Unknown'),
        };
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-emerald-50 text-emerald-600',
            'onboarding' => 'bg-blue-50 text-blue-600',
            'suspended' => 'bg-amber-50 text-amber-600',
            'inactive' => 'bg-gray-100 text-gray-600',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    /**
     * Generate subdomain from business name
     */
    public static function generateSubdomain(string $name): string
    {
        $slug = \Illuminate\Support\Str::slug($name);
        return $slug . '.desa.begawi.id';
    }
}

