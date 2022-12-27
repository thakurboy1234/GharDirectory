<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Models\BaseModel;

class FeatureTranslation extends BaseModel
{
    protected $table = 're_features_translations';

    protected $fillable = [
        'lang_code',
        're_features_id',
        'name',
    ];

    public $timestamps = false;
}
