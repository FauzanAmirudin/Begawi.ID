<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportTicket extends Model
{
    protected $fillable = [
        'ticket_code',
        'created_by',
        'subject',
        'message',
        'category',
        'priority',
        'status',
        'assigned_to',
        'response',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
        ];
    }

    /**
     * Get the user who created this ticket
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user assigned to this ticket
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Generate ticket code
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_code)) {
                $ticket->ticket_code = 'TCK-' . date('Y') . '-' . str_pad(SupportTicket::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
