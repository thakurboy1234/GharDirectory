<?php

namespace Botble\Base\Facades;

use Botble\Base\Supports\BreadcrumbsManager;
use Illuminate\Support\Facades\Facade;

class BreadcrumbsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BreadcrumbsManager::class;
    }
}
