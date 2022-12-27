<?php

namespace Botble\Base\Facades;

use Illuminate\Support\Facades\Facade;

class ActionFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'core:action';
    }
}
