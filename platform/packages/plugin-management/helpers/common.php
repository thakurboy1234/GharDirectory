<?php

if (! function_exists('plugin_path')) {
    /**
     * @param ?string $path
     * @return string
     */
    function plugin_path(?string $path = null): string
    {
        return platform_path('plugins' . DIRECTORY_SEPARATOR . $path);
    }
}

if (! function_exists('is_plugin_active')) {
    /**
     * @param string $alias
     * @return bool
     */
    function is_plugin_active(string $alias): bool
    {
        return in_array($alias, get_active_plugins());
    }
}

if (! function_exists('get_active_plugins')) {
    /**
     * @return array
     */
    function get_active_plugins(): array
    {
        return array_unique(json_decode(setting('activated_plugins', '[]'), true));
    }
}

if (! function_exists('get_installed_plugins')) {
    /**
     * @return array
     */
    function get_installed_plugins(): array
    {
        $list = [];
        $plugins = BaseHelper::scanFolder(plugin_path());

        if (! empty($plugins)) {
            foreach ($plugins as $plugin) {
                $path = plugin_path($plugin);
                if (! File::isDirectory($path) || ! File::exists($path . '/plugin.json')) {
                    continue;
                }

                $list[] = $plugin;
            }
        }

        return $list;
    }
}
