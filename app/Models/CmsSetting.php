<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CmsSetting extends Model
{
    protected $fillable = ['key', 'value', 'label', 'group'];

    /**
     * Get a setting value by key with optional cache.
     */
    public static function getValue(string $key, string $default = ''): string
    {
        return Cache::remember("cms_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? ($setting->value ?? $default) : $default;
        });
    }

    /**
     * Update a setting value and clear its cache.
     */
    public static function set(string $key, mixed $value, ?string $group = null, ?string $label = null): void
    {
        $attributes = ['value' => $value];
        if ($group !== null) {
            $attributes['group'] = $group;
        }
        if ($label !== null) {
            $attributes['label'] = $label;
        }

        static::updateOrCreate(['key' => $key], $attributes);
        Cache::forget("cms_{$key}");
    }

    /**
     * Get all settings in a given group as key => value array.
     */
    public static function getGroup(string $group): array
    {
        return static::where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }
}
