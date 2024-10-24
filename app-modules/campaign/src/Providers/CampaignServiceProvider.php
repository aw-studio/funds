<?php

namespace Funds\Campaign\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class CampaignServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'campaign');
        $this->loadJsonTranslationsFrom(__DIR__.'/../../resources/lang');
        $this->loadViewsFrom(__DIR__.'/../../resources/views/public', 'public');

        Volt::mount([
            base_path('modules/Campaign/Views/livewire'),
        ]);

    }
}
