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
        $this->loadViewsFrom(__DIR__.'/../Views', 'campaign');
        $this->loadJsonTranslationsFrom(__DIR__.'/../lang');
        $this->loadViewsFrom(__DIR__.'/../Views/public', 'public');

        Volt::mount([
            base_path('modules/Campaign/Views/livewire'),
        ]);

    }
}
