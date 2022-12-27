<?php

namespace Botble\AuditLog\Facades;

use Botble\AuditLog\AuditLog;
use Illuminate\Support\Facades\Facade;

class AuditLogFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AuditLog::class;
    }
}
