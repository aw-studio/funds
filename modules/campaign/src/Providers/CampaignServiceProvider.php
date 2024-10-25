<?php

namespace Funds\Campaign\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class CampaignServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'campaign');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/public', 'public');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadJsonTranslationsFrom(__DIR__.'/../../resources/lang');

        Volt::mount([
            __DIR__.'/../../resources/views/livewire',
        ]);

    }
}
