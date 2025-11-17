<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Village extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'website_id',
        'name',
        'slug',
        'tagline',
        'head',
        'head_title',
        'location',
        'code',
        'population',
        'area',
        'density',
        'logo_path',
        'description',
        'vision',
        'vision_period',
        'missions',
        'contacts',
        'structures',
        'history',
        'image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'missions' => 'array',
        'contacts' => 'array',
        'structures' => 'array',
        'history' => 'array',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function news(): HasMany
    {
        return $this->hasMany(VillageNews::class);
    }

    public function agendas(): HasMany
    {
        return $this->hasMany(VillageAgenda::class);
    }

    public function galleryCategories(): HasMany
    {
        return $this->hasMany(VillageGalleryCategory::class);
    }

    public function galleryItems(): HasMany
    {
        return $this->hasMany(VillageGalleryItem::class);
    }

    public function potentials(): HasMany
    {
        return $this->hasMany(VillagePotential::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(VillageAchievement::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(VillageProgram::class);
    }

    /**
     * Get users that belong to this village (editors)
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get letter submissions for this village
     */
    public function letterSubmissions(): HasMany
    {
        return $this->hasMany(LetterSubmission::class);
    }

    /**
     * Get citizen complaints for this village
     */
    public function citizenComplaints(): HasMany
    {
        return $this->hasMany(CitizenComplaint::class);
    }
}
