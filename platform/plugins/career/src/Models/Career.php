<?php

namespace Botble\Career\Models;

use Botble\Base\Models\BaseModel;
use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;

class Career extends BaseModel
{
    use EnumCastable;

    protected $table = 'careers';

    protected $fillable = [
        'name',
        'location',
        'salary',
        'description',
        'content',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
