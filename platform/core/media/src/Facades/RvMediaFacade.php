<?php

namespace Botble\Media\Facades;

use Botble\Media\RvMedia;
use Illuminate\Support\Facades\Facade;

class RvMediaFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RvMedia::class;
    }
}
