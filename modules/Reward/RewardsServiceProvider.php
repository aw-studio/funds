<?php

namespace Funds\Reward;

use Illuminate\Support\ServiceProvider;

class RewardsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'rewards');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
