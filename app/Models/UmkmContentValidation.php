<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UmkmContentValidation extends Model
{
    protected $fillable = [
        'umkm_business_id',
        'submitted_by',
        'content_type',
        'title',
        'description',
        'content_data',
        'status',
        'rejection_reason',
        'revision_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'content_data' => 'array',
            'reviewed_at' => 'datetime',
        ];
    }

    public function umkmBusiness(): BelongsTo
    {
        return $this->belongsTo(UmkmBusiness::class, 'umkm_business_id');
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get content type label
     */
    public function getContentTypeLabelAttribute(): string
    {
        return match($this->content_type) {
            'product' => 'Produk Baru',
            'photo' => 'Foto Produk',
            'promotion' => 'Promosi',
            'profile_update' => 'Update Profil',
            default => 'Konten',
        };
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'review' => 'bg-sky-50 text-sky-600',
            'verification' => 'bg-purple-50 text-purple-600',
            'approved' => 'bg-emerald-50 text-emerald-600',
            'rejected' => 'bg-rose-50 text-rose-600',
            'revision_requested' => 'bg-amber-50 text-amber-600',
            'draft' => 'bg-gray-100 text-gray-600',
            default => 'bg-gray-100 text-gray-600',
        };
    }
}

