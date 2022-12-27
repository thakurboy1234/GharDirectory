<?php

namespace Botble\RealEstate\Facades;

use Botble\RealEstate\Supports\CurrencySupport;
use Illuminate\Support\Facades\Facade;

class CurrencyFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CurrencySupport::class;
    }
}
