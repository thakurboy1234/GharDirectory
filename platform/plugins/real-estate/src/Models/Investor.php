<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Investor extends BaseModel
{
    use EnumCastable;

    protected $table = 're_investors';

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
