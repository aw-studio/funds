<?php

namespace Funds\Donations;

use Funds\Core\Facades\Funds;
use Funds\Donations\Payment\StripePaymentGateway;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Volt\Volt;

class DonationsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // register the payment gateway used for donations
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/Views', 'donations');

        Volt::mount([
            base_path('modules/Donations/Views/livewire'),
        ]);

        Funds::payment()->register(StripePaymentGateway::class);

        Blade::component('stripe-payment-elements', \Funds\Donations\Payment\StripePaymentElements::class);

        // $this->callAfterResolving(BladeCompiler::class, function () {
        //     Blade::component('stripe-payment-elements', \Funds\Donations\Payment\StripePaymentElements::class);
        // });

    }
}
