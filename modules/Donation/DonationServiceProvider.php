<?php

namespace Funds\Donation;

use Funds\Donation\Payment\StripePaymentGateway;
use Funds\Donation\Services\DonationIntentService;
use Funds\Donation\Services\DonationService;
use Funds\Foundation\Contracts\DonationIntentServiceInterface;
use Funds\Foundation\Contracts\DonationServiceInterface;
use Funds\Foundation\Facades\Funds;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Volt\Volt;

class DonationServiceProvider extends ServiceProvider
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

        $this->loadViewsFrom(__DIR__.'/Views/public', 'public');

        $this->loadJsonTranslationsFrom(__DIR__.'/lang');

        Volt::mount([
            base_path('modules/Donation/Views/livewire'),
        ]);

        Funds::payment()->register(StripePaymentGateway::class);

        $this->app->singleton(DonationServiceInterface::class, DonationService::class);
        $this->app->singleton(DonationIntentServiceInterface::class, DonationIntentService::class);

        Blade::component('stripe-payment-elements', \Funds\Donation\Payment\StripePaymentElements::class);

        // $this->callAfterResolving(BladeCompiler::class, function () {
        //     Blade::component('stripe-payment-elements', \Funds\Donation\Payment\StripePaymentElements::class);
        // });

    }
}
