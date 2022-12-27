<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Models\BaseModel;
use Botble\Base\Traits\EnumCastable;
use Botble\RealEstate\Enums\ProjectStatusEnum;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use RvMedia;

class Project extends BaseModel
{
    use EnumCastable;

    protected $table = 're_projects';

    protected $fillable = [
        'name',
        'description',
        'content',
        'location',
        'images',
        'status',
        'is_featured',
        'investor_id',
        'number_block',
        'number_floor',
        'number_flat',
        'date_finish',
        'date_sell',
        'price_from',
        'price_to',
        'currency_id',
        'city_id',
        'state_id',
        'country_id',
        'author_id',
        'author_type',
        'category_id',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'status' => ProjectStatusEnum::class,
    ];

    public function property(): HasMany
    {
        return $this->hasMany(Property::class, 'project_id');
    }

    public function getImagesAttribute($value): array
    {
        try {
            if ($value === '[null]') {
                return [];
            }

            $images = json_decode((string)$value, true);

            if (is_array($images)) {
                $images = array_filter($images);
            }

            return $images ?: [];
        } catch (Exception) {
            return [];
        }
    }

    public function getImageAttribute(): ?string
    {
        return Arr::first($this->images) ?? null;
    }

    public function setDateFinishAttribute(?string $value): void
    {
        $this->attributes['date_finish'] = Carbon::parse($value)->toDateString();
    }

    public function setDateSellAttribute(?string $value): void
    {
        $this->attributes['date_sell'] = Carbon::parse($value)->toDateString();
    }

    public function investor(): BelongsTo
    {
        return $this->belongsTo(Investor::class)->withDefault();
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 're_project_features', 'project_id', 'feature_id');
    }

    public function facilities(): BelongsToMany
    {
        return $this->morphToMany(Facility::class, 'reference', 're_facilities_distances')->withPivot('distance');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class)->withDefault();
    }

    public function getAddressAttribute(): ?string
    {
        return $this->location;
    }

    public function getCategoryAttribute(): Category
    {
        return $this->categories->first() ?: new Category();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 're_project_categories');
    }

    public function getCategoryNameAttribute(): ?string
    {
        return $this->category->name;
    }

    public function getImageThumbAttribute(): ?string
    {
        return $this->image ? RvMedia::getImageUrl($this->image, 'thumb', false, RvMedia::getDefaultImage()) : null;
    }

    public function getImageSmallAttribute(): ?string
    {
        return $this->image ? RvMedia::getImageUrl($this->image, 'small', false, RvMedia::getDefaultImage()) : null;
    }

    public function getMapIconAttribute(): ?string
    {
        return $this->name;
    }

    public function getCityNameAttribute(): string
    {
        return $this->city->name . ', ' . $this->city->state->name;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Project $project) {
            $project->categories()->detach();
        });
    }
}
