<?php

namespace Funds\Foundation\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ExtensionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $extensions = glob(base_path('extensions/*'), GLOB_ONLYDIR);

        foreach ($extensions as $extension) {
            $this->registerExtension($extension);
        }

    }

    protected function registerExtension($extension)
    {
        $composerJsonPath = $extension.'/composer.json';

        if (! file_exists($composerJsonPath)) {
            return;
        }

        $composerConfig = json_decode(file_get_contents($composerJsonPath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            logger()->error("Error parsing composer.json file for extension: {$extension}");

            return;
        }

        $extensionsJson = $this->getExtensionsConfig();

        if (! in_array($composerConfig['name'], $extensionsJson['enabled'] ?? [])) {
            return;
        }

        if (isset($composerConfig['extra']['laravel']['providers'])) {
            foreach ($composerConfig['extra']['laravel']['providers'] as $provider) {
                $this->app->register($provider);
            }
        }
    }

    protected function getExtensionsConfig(): array
    {
        static $extensionsJson = null;

        if ($extensionsJson === null) {
            $configFilePath = base_path('extensions/extensions.json');

            if (! File::exists($configFilePath)) {
                File::put($configFilePath, json_encode([
                    'installed' => [],
                    'enabled' => [],
                ], JSON_PRETTY_PRINT));
            }

            $extensionsJson = json_decode(file_get_contents($configFilePath), true) ?? [];
        }

        return $extensionsJson;
    }

    protected function registerCommands()
    {
        $this->commands([
        ]);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }

    }
}
