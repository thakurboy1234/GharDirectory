<?php

namespace Botble\RealEstate\Providers;

use Botble\RealEstate\Listeners\UpdatedContentListener;
use Botble\Base\Events\UpdatedContentEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
    ];
}
