<?php

namespace Botble\LanguageAdvanced\Listeners;

use Botble\Base\Events\DeletedContentEvent;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Illuminate\Support\Facades\DB;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event): void
    {
        if (LanguageAdvancedManager::isSupported($event->data)) {
            $table = $event->data->getTable() . '_translations';

            DB::table($table)->where([$event->data->getTable() . '_id' => $event->data->id])->delete();
        }
    }
}
