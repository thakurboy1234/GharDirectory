<?php

namespace Botble\Installer\Http\Middleware;

use Botble\Base\Supports\Helper;
use Illuminate\Support\Facades\File;

abstract class InstallerMiddleware
{
    public function alreadyInstalled(): bool
    {
        if (Helper::isConnectedDatabase() && ! File::exists(storage_path('installing'))) {
            return true;
        }

        return File::exists(storage_path('installed'));
    }
}
