<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'title',
        'year',
        'category',
        'organizer',
        'description',
        'attachment_path',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
