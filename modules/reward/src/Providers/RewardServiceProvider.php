<?php

namespace Funds\Reward\Providers;

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

        Volt::mount([
            __DIR__.'/../../resources/views/livewire',
        ]);

    }
}
