<?php

namespace Botble\Base\Facades;

use Botble\Base\Supports\MacroableModels;
use Illuminate\Support\Facades\Facade;

class MacroableModelsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MacroableModels::class;
    }
}
