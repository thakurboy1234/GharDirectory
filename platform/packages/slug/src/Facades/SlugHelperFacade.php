<?php

namespace Botble\Slug\Facades;

use Botble\Slug\SlugHelper;
use Illuminate\Support\Facades\Facade;

class SlugHelperFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SlugHelper::class;
    }
}
