<?php

namespace Funds\Foundation;

use Funds\Foundation\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class SettingsService
{
    public function get($key, $default = '')
    {
        return Cache::rememberForever('settings.'.$key, function () use ($key, $default) {
            $setting = Setting::where('key', $key)->first();

            if ($setting && Str::of($setting->value)->startsWith('media::')) {
                return $setting->getFirstMediaUrl('settings.'.$key) ?? $default;
            }

            return $setting?->value ?? $default;
        });
    }

    public function set($key, $value)
    {
        if ($value instanceof File) {
            return $this->setMediaSetting($key, $value);
        }

        if ($value === null) {
            return $this->clear($key);
        }

        $setting = Setting::updateOrCreate(
            [
                'key' => $key,
            ],
            [
                'value' => $value,
            ]
        );

        Cache::forever('settings.'.$key, $value);

        return $setting;
    }

    public function all()
    {
        return Setting::all()->map(function (Setting $setting, $key) {
            if (Str::of($setting->value)->startsWith('media::')) {
                $setting->value = $setting->getFirstMediaUrl('settings.logo');
            }

            return $setting;
        })
            ->pluck('value', 'key')
            ->toArray();
    }

    public function clear($key)
    {
        $setting = Setting::where('key', $key)->first();

        if (! $setting) {
            return;
        }

        if (Str::of($setting->value)->startsWith('media::')) {
            $setting->clearMediaCollection('settings.'.$key);
        }

        Cache::forget('settings.'.$key);

        $setting->delete();

    }

    protected function setMediaSetting($key, $value)
    {
        $this->clear($key);

        $setting = Setting::updateOrCreate(['key' => $key]);

        $collectionName = 'settings.'.$key;

        $setting->addMedia($value)
            ->toMediaCollection($collectionName);

        $setting->update(['value' => 'media::'.$collectionName]);

        Cache::forever('settings.'.$key, $setting->getFirstMediaUrl($collectionName));

        return $setting;
    }
}
