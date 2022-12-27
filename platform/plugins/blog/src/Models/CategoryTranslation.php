<?php

namespace Botble\Blog\Models;

use Botble\Base\Models\BaseModel;

class CategoryTranslation extends BaseModel
{
    protected $table = 'categories_translations';

    protected $fillable = [
        'lang_code',
        'categories_id',
        'name',
        'description',
    ];

    public $timestamps = false;
}
