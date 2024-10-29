<?php

namespace Funds\Reward\Providers;

use Funds\Reward\View\RewardShippingOptions;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class RewardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'rewards');
        $this->loadJsonTranslationsFrom(__DIR__.'/../../resources/lang');
        $this->mergeConfigFrom(__DIR__.'/../../config/rewards.php', 'rewards');

        Blade::component(RewardShippingOptions::class, 'rewards::shipping-options');

        Volt::mount([
            __DIR__.'/../../resources/views/livewire',
        ]);

    }
}
