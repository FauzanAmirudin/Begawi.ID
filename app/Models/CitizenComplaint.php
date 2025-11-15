<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CitizenComplaint extends Model
{
    protected $fillable = [
        'tracking_code',
        'village_id',
        'nama',
        'telepon',
        'email',
        'kategori',
        'lokasi',
        'judul',
        'deskripsi',
        'bukti_files',
        'is_anonymous',
        'status',
        'admin_notes',
        'processed_by',
        'reviewed_at',
        'in_progress_at',
        'resolved_at',
        'rejected_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'bukti_files' => 'array',
            'is_anonymous' => 'boolean',
            'reviewed_at' => 'datetime',
            'in_progress_at' => 'datetime',
            'resolved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    /**
     * Get the village that owns this complaint
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the user who processed this complaint
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Generate tracking code
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($complaint) {
            if (empty($complaint->tracking_code)) {
                $date = date('Ymd');
                $count = static::whereDate('created_at', today())->count() + 1;
                $complaint->tracking_code = 'ADU-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Get category name
     */
    public function getCategoryNameAttribute(): string
    {
        $categories = [
            'pelayanan-umum' => 'Pelayanan Umum',
            'infrastruktur' => 'Infrastruktur',
            'sosial' => 'Sosial Kemasyarakatan',
            'keamanan' => 'Keamanan & Ketertiban',
        ];

        return $categories[$this->kategori] ?? $this->kategori;
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'reviewed' => 'blue',
            'in_progress' => 'purple',
            'resolved' => 'green',
            'rejected' => 'red',
            default => 'gray',
        };
    }
}
