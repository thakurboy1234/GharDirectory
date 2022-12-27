<?php

namespace Botble\Base\Facades;

use Botble\Base\Supports\Assets;
use Illuminate\Support\Facades\Facade;

class AssetsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Assets::class;
    }
}
