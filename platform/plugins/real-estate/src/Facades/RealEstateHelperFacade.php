<?php

namespace Botble\RealEstate\Facades;

use Botble\RealEstate\Supports\RealEstateHelper;
use Illuminate\Support\Facades\Facade;

class RealEstateHelperFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RealEstateHelper::class;
    }
}
