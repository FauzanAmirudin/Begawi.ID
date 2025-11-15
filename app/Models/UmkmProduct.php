<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UmkmProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_business_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'availability_status',
        'labels',
        'variants',
        'weight',
        'dimension',
        'sold_count',
        'view_count',
        'rating',
        'rating_count',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock' => 'integer',
        'labels' => 'array',
        'variants' => 'array',
        'sold_count' => 'integer',
        'view_count' => 'integer',
        'rating' => 'decimal:2',
        'rating_count' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    const AVAILABILITY_READY = 'ready';
    const AVAILABILITY_PRE_ORDER = 'pre_order';

    const LABEL_BEST_SELLER = 'best_seller';
    const LABEL_NEW = 'new';
    const LABEL_PROMO = 'promo';

    public function umkmBusiness()
    {
        return $this->belongsTo(UmkmBusiness::class);
    }

    public function category()
    {
        return $this->belongsTo(UmkmProductCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(UmkmProductImage::class, 'product_id');
    }

    public function primaryImage()
    {
        return $this->hasOne(UmkmProductImage::class, 'product_id')->where('is_primary', true);
    }

    public function hasLabel($label)
    {
        return in_array($label, $this->labels ?? []);
    }

    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('title') && empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });
    }
}

