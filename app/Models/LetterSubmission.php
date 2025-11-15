<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterSubmission extends Model
{
    protected $fillable = [
        'tracking_code',
        'village_id',
        'letter_type',
        'nama',
        'nik',
        'telepon',
        'email',
        'alamat',
        'keperluan',
        'requirements_files',
        'status',
        'admin_notes',
        'completed_file_path',
        'processed_by',
        'verified_at',
        'processed_at',
        'completed_at',
        'rejected_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'requirements_files' => 'array',
            'verified_at' => 'datetime',
            'processed_at' => 'datetime',
            'completed_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    /**
     * Get the village that owns this submission
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get the user who processed this submission
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

        static::creating(function ($submission) {
            if (empty($submission->tracking_code)) {
                $date = date('Ymd');
                $count = static::whereDate('created_at', today())->count() + 1;
                $submission->tracking_code = 'SRT-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Get letter type name
     */
    public function getLetterTypeNameAttribute(): string
    {
        $types = [
            'ktp' => 'Surat Pengantar KTP',
            'domisili' => 'Surat Keterangan Domisili',
            'usaha' => 'Surat Keterangan Usaha',
            'tidak-mampu' => 'Surat Keterangan Tidak Mampu',
            'belum-menikah' => 'Surat Keterangan Belum Menikah',
            'kelahiran' => 'Surat Keterangan Kelahiran',
        ];

        return $types[$this->letter_type] ?? $this->letter_type;
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'verified' => 'blue',
            'processed' => 'purple',
            'completed' => 'green',
            'rejected' => 'red',
            default => 'gray',
        };
    }
}
