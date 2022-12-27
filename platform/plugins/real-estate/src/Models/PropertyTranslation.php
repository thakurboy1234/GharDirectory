<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Models\BaseModel;

class PropertyTranslation extends BaseModel
{
    protected $table = 're_properties_translations';

    protected $fillable = [
        'lang_code',
        're_properties_id',
        'name',
        'description',
        'content',
        'location',
    ];

    public $timestamps = false;
}
