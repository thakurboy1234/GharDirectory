<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Models\BaseModel;

class CategoryTranslation extends BaseModel
{
    protected $table = 're_categories_translations';

    protected $fillable = [
        'lang_code',
        're_categories_id',
        'name',
        'description',
    ];

    public $timestamps = false;
}
