<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillagePotential extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'Aktif';
    public const STATUS_DEVELOPMENT = 'Pengembangan';
    public const STATUS_INACTIVE = 'Nonaktif';

    protected $fillable = [
        'village_id',
        'title',
        'slug',
        'category',
        'status',
        'featured_image',
        'summary',
        'description',
        'map_embed',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
