<?php

namespace Funds\Campaign\Providers;

use Funds\Campaign\Views\ViewComponents\CampaignLayout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class CampaignServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        $this->loadViewsFrom(__DIR__.'/../Views', 'campaigns');
        $this->loadJsonTranslationsFrom(__DIR__.'/../lang');
        // not really required if we are going to inject the campaign?
        Blade::component(CampaignLayout::class, 'campaign-layout');
        Volt::mount([
            base_path('modules/Campaign/Views/livewire'),
        ]);

    }
}
