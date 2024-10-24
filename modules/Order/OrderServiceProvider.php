<?php

namespace Funds\Order;

use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(OrderEventServiceProvider::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/Views', 'order');

        view()->composer('donations::show', function ($view) {
            $view->with('widgets',
                view('order::components.donation-order', $view->getData()));
        });

    }
}
