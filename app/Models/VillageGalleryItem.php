<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageGalleryItem extends Model
{
    use HasFactory;

    public const TYPE_PHOTO = 'photo';
    public const TYPE_VIDEO = 'video';

    protected $fillable = [
        'village_id',
        'category_id',
        'created_by',
        'title',
        'description',
        'type',
        'media_path',
        'video_url',
        'thumbnail_path',
        'taken_at',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'taken_at' => 'date',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(VillageGalleryCategory::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
