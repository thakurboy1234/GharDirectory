<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Facility extends BaseModel
{
    use EnumCastable;

    protected $table = 're_facilities';

    protected $fillable = [
        'name',
        'icon',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
