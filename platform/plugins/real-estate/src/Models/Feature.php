<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends BaseModel
{
    protected $table = 're_features';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'icon',
    ];

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 're_property_features', 'feature_id', 'property_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 're_project_features', 'feature_id', 'project_id');
    }
}
