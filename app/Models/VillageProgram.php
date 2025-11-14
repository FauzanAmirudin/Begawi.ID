<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageProgram extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'Aktif';
    public const STATUS_COMPLETED = 'Selesai';
    public const STATUS_ON_HOLD = 'Ditangguhkan';

    protected $fillable = [
        'village_id',
        'title',
        'period',
        'lead',
        'progress',
        'status',
        'description',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'progress' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
