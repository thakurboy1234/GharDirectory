<?php

namespace Botble\Base\Providers;

use Botble\Base\Commands\CleanupSystemCommand;
use Botble\Base\Commands\ClearLogCommand;
use Botble\Base\Commands\InstallCommand;
use Botble\Base\Commands\PublishAssetsCommand;
use Botble\Base\Commands\UpdateCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            ClearLogCommand::class,
            InstallCommand::class,
            UpdateCommand::class,
            PublishAssetsCommand::class,
            CleanupSystemCommand::class,
        ]);
    }
}
