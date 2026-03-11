<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'label', 'type'];

    /**
     * Get a setting value by key with optional default.
     */
    public static function get(string $key, string $default = ''): string
    {
        $settings = Cache::remember('site_settings', 300, function () {
            return self::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Set / update a setting value.
     */
    public static function set(string $key, ?string $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }

    /**
     * Get all settings grouped.
     */
    public static function allGrouped(): array
    {
        return self::orderBy('id')->get()->groupBy('group')->toArray();
    }
}
