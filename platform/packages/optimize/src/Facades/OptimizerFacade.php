<?php

namespace Botble\Optimize\Facades;

use Botble\Optimize\Supports\Optimizer;
use Illuminate\Support\Facades\Facade;

class OptimizerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Optimizer::class;
    }
}
