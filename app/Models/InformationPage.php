<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InformationPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'page_type',
        'featured_image',
        'is_published',
        'is_featured',
        'views',
        'sort_order',
        'created_by',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'views' => 'integer',
            'sort_order' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Get the user who created this page
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get page type options
     */
    public static function getPageTypes(): array
    {
        return ['info', 'faq', 'help', 'about', 'terms', 'privacy'];
    }
}
