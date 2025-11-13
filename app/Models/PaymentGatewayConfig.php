<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewayConfig extends Model
{
    protected $fillable = [
        'gateway',
        'environment',
        'server_key',
        'client_key',
        'api_key',
        'secret_key',
        'is_active',
        'additional_config',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'additional_config' => 'array',
        ];
    }

    /**
     * Get gateway label
     */
    public function getGatewayLabelAttribute(): string
    {
        return match($this->gateway) {
            'midtrans' => 'Midtrans',
            'xendit' => 'Xendit',
            default => 'Unknown',
        };
    }

    /**
     * Get environment label
     */
    public function getEnvironmentLabelAttribute(): string
    {
        return $this->environment === 'production' ? 'Production' : 'Sandbox';
    }
}
