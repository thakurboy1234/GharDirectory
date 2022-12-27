<?php

namespace Botble\Location\Models;

use Botble\Base\Models\BaseModel;

class StateTranslation extends BaseModel
{
    protected $table = 'states_translations';

    protected $fillable = [
        'lang_code',
        'states_id',
        'name',
        'abbreviation',
    ];

    public $timestamps = false;
}
