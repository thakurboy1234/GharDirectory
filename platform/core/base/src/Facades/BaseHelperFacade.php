<?php

namespace Botble\Base\Facades;

use Botble\Base\Helpers\BaseHelper;
use Illuminate\Support\Facades\Facade;

class BaseHelperFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BaseHelper::class;
    }
}
