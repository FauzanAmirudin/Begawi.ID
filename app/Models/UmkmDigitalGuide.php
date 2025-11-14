<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UmkmDigitalGuide extends Model
{
    protected $fillable = [
        'village_id',
        'created_by',
        'title',
        'slug',
        'description',
        'category',
        'file_path',
        'file_type',
        'external_link',
        'duration_minutes',
        'is_published',
        'notify_all_umkm',
        'published_at',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'notify_all_umkm' => 'boolean',
            'published_at' => 'datetime',
            'views_count' => 'integer',
            'duration_minutes' => 'integer',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Generate slug from title
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($guide) {
            if (empty($guide->slug)) {
                $guide->slug = Str::slug($guide->title);
            }
        });
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'tips' => 'Tips Promosi',
            'pelatihan' => 'Pelatihan Online',
            'artikel' => 'Artikel Edukasi',
            'video' => 'Video Tutorial',
            'template' => 'Template',
            default => 'Materi',
        };
    }
}

