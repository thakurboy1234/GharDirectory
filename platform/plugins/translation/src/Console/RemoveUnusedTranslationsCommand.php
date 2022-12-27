<?php

namespace Botble\Translation\Console;

use Botble\Translation\Manager;
use Botble\Translation\Models\Translation;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('cms:translations:remove-unused-translations', 'Remove unused translations')]
class RemoveUnusedTranslationsCommand extends Command
{
    public function handle(Manager $manager): int
    {
        $this->info('Remove unused translations in resource/lang...');

        foreach (File::directories(lang_path('vendor/packages')) as $package) {
            if (! File::isDirectory(package_path(File::basename($package)))) {
                File::deleteDirectory($package);
            }
        }

        foreach (File::directories(lang_path('vendor/plugins')) as $plugin) {
            if (! File::isDirectory(plugin_path(File::basename($plugin)))) {
                File::deleteDirectory($plugin);
            }
        }

        $manager->removeUnusedThemeTranslations();

        $this->info('Importing...');
        $manager->importTranslations();

        $groups = Translation::groupBy('group')->pluck('group');

        $counter = 0;
        foreach ($groups as $group) {
            $keys = Translation::where('group', $group)
                ->where('locale', 'en')
                ->pluck('key');

            $counter += Translation::where('locale', '!=', 'en')
                ->where('group', $group)
                ->whereNotIn('key', $keys)
                ->delete();
        }

        $manager->exportAllTranslations();

        $this->info('Exporting...');
        $this->info('Done! Deleted ' . $counter . ' items!');

        return self::SUCCESS;
    }
}
