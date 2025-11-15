<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageAgenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'title',
        'description',
        'date',
        'time',
        'location',
        'category',
        'timeline',
        'checklist',
        'organizers',
        'is_published',
    ];

    protected $casts = [
        'date' => 'date',
        'timeline' => 'array',
        'checklist' => 'array',
        'organizers' => 'array',
        'is_published' => 'boolean',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
