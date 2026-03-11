<?php

use App\Models\SiteSetting;

if (!function_exists('setting')) {
    /**
     * Get a site setting value.
     *
     * @param  string  $key
     * @param  string  $default
     * @return string
     */
    function setting(string $key, string $default = ''): string
    {
        return SiteSetting::get($key, $default);
    }
}
