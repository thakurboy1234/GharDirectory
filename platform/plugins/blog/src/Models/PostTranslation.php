<?php

namespace Botble\Blog\Models;

use Botble\Base\Models\BaseModel;

class PostTranslation extends BaseModel
{
    protected $table = 'posts_translations';

    protected $fillable = [
        'lang_code',
        'posts_id',
        'name',
        'description',
        'content',
    ];

    public $timestamps = false;
}
