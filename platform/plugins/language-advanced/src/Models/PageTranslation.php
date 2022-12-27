<?php

namespace Botble\LanguageAdvanced\Models;

use Botble\Base\Models\BaseModel;

class PageTranslation extends BaseModel
{
    protected $table = 'pages_translations';

    protected $fillable = [
        'lang_code',
        'pages_id',
        'name',
        'description',
        'content',
    ];

    public $timestamps = false;
}
