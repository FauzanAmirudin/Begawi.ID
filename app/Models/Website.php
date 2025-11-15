<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Website extends Model
{
    protected $fillable = [
        'name',
        'type',
        'url',
        'custom_domain',
        'status',
        'user_id',
        'template_id',
        'dns_status',
        'domain_expires_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'domain_expires_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the website.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the village associated with this website (for desa type)
     */
    public function village(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Village::class);
    }

    /**
     * Get the UMKM business associated with this website (for umkm type)
     */
    public function umkmBusiness(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\UmkmBusiness::class);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'green',
            'suspended' => 'red',
            'inactive' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Get type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'desa' => 'Desa',
            'umkm' => 'UMKM',
            default => 'Unknown',
        };
    }
}
