<?php

namespace Botble\SocialLogin\Facades;

use Botble\SocialLogin\Supports\SocialService;
use Illuminate\Support\Facades\Facade;

class SocialServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SocialService::class;
    }
}
