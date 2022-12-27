<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Models\BaseModel;

class ProjectTranslation extends BaseModel
{
    protected $table = 're_projects_translations';

    protected $fillable = [
        'lang_code',
        're_projects_id',
        'name',
        'description',
        'content',
        'location',
    ];

    public $timestamps = false;
}
