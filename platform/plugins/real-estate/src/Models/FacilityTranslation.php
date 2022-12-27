<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Models\BaseModel;

class FacilityTranslation extends BaseModel
{
    protected $table = 're_facilities_translations';

    protected $fillable = [
        'lang_code',
        're_facilities_id',
        'name',
    ];

    public $timestamps = false;
}
