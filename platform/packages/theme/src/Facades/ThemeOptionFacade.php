<?php

namespace Botble\Theme\Facades;

use Botble\Theme\ThemeOption;
use Illuminate\Support\Facades\Facade;

class ThemeOptionFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ThemeOption::class;
    }
}
