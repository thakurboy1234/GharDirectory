<?php

namespace Botble\Base\Facades;

use Botble\Base\Supports\DashboardMenu;
use Illuminate\Support\Facades\Facade;

class DashboardMenuFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DashboardMenu::class;
    }
}
