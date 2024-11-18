<?php

namespace Funds\Donation\Providers;

use Funds\Donation\Events\DonationIntentSucceeded;
use Funds\Donation\Models\Donation;
use Funds\Donation\Notifications\DonationReceivedNotification;
use Funds\Donation\Payment\StripePaymentGateway;
use Funds\Donation\Services\DonationIntentService;
use Funds\Donation\Services\DonationService;
use Funds\Foundation\Contracts\DonationIntentServiceInterface;
use Funds\Foundation\Contracts\DonationServiceInterface;
use Funds\Foundation\Facades\Funds;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class DonationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // register the payment gateway used for donations
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'donation');
        $this->loadViewsFrom(__DIR__.'/../../resources/views/public', 'public');
        $this->loadJsonTranslationsFrom(__DIR__.'/../../resources/lang');

        Volt::mount([
            __DIR__.'/../../resources/views/livewire',
        ]);

        Funds::payment()->register(StripePaymentGateway::class);

        $this->app->singleton(DonationServiceInterface::class, DonationService::class);
        $this->app->singleton(DonationIntentServiceInterface::class, DonationIntentService::class);

        Blade::component('stripe-payment-elements', \Funds\Donation\Payment\StripePaymentElements::class);

        Event::listen(DonationIntentSucceeded::class, function (DonationIntentSucceeded $event) {
            $donation = Donation::find($event->donationIntentData->donationId);
            $donation->donor->notify(new DonationReceivedNotification($donation));
        });

    }
}
