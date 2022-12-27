<?php

namespace Botble\Language\Facades;

use Botble\Language\LanguageManager;
use Illuminate\Support\Facades\Facade;

class LanguageFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return LanguageManager::class;
    }
}
