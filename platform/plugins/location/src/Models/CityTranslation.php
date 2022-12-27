<?php

namespace Botble\Location\Models;

use Botble\Base\Models\BaseModel;

class CityTranslation extends BaseModel
{
    protected $table = 'cities_translations';

    protected $fillable = [
        'lang_code',
        'cities_id',
        'name',
    ];

    public $timestamps = false;
}
