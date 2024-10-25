<?php

namespace Funds\Order\Providers;

use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(OrderEventServiceProvider::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'order');

        view()->composer('donation::show', function ($view) {
            $view->with('widgets',
                view('order::components.donation-order', $view->getData()));
        });

    }
}
