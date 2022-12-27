<?php

namespace Botble\Location\Models;

use Botble\Base\Models\BaseModel;

class CountryTranslation extends BaseModel
{
    protected $table = 'countries_translations';

    protected $fillable = [
        'lang_code',
        'countries_id',
        'name',
        'nationality',
    ];

    public $timestamps = false;
}
