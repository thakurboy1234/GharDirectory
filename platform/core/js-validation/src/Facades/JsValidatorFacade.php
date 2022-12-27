<?php

namespace Botble\JsValidation\Facades;

use Illuminate\Support\Facades\Facade;

class JsValidatorFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'js-validator';
    }
}
