<?php

namespace Funds\Reward;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class RewardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'rewards');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__.'/lang');

        Volt::mount([
            __DIR__.'/views/livewire',
        ]);

    }
}
