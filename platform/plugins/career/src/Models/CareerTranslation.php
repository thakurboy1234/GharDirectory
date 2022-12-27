<?php

namespace Botble\Career\Models;

use Botble\Base\Models\BaseModel;

class CareerTranslation extends BaseModel
{
    protected $table = 'careers_translations';

    protected $fillable = [
        'lang_code',
        'careers_id',
        'name',
        'location',
        'salary',
        'description',
    ];

    public $timestamps = false;
}
