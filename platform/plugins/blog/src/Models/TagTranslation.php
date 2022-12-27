<?php

namespace Botble\Blog\Models;

use Botble\Base\Models\BaseModel;

class TagTranslation extends BaseModel
{
    protected $table = 'tags_translations';

    protected $fillable = [
        'lang_code',
        'tags_id',
        'name',
        'description',
    ];

    public $timestamps = false;
}
