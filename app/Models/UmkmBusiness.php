<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class UmkmBusiness extends Model
{
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
        'category',
        'description',
        'logo_path',
        'legal_document_path',
        'status',
        'products_count',
        'visits_count',
        'orders_count',
        'last_activity_at',
    ];

    protected function casts(): array
    {
        return [
            'last_activity_at' => 'datetime',
        ];
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contentValidations(): HasMany
    {
        return $this->hasMany(UmkmContentValidation::class, 'umkm_business_id');
    }

    /**
     * Generate subdomain from name
     */
    public static function generateSubdomain(string $name, string $domainSuffix = 'desa.begawi.id'): string
    {
        $slug = Str::slug($name);
        return "{$slug}.{$domainSuffix}";
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-emerald-50 text-emerald-600',
            'onboarding' => 'bg-sky-50 text-sky-600',
            'suspended' => 'bg-rose-50 text-rose-600',
            'inactive' => 'bg-gray-100 text-gray-600',
            default => 'bg-gray-100 text-gray-600',
        };
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
            default => 'Unknown',
        };
    }
}

