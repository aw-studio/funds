<?php

namespace Funds\RecurringDonations;

use Funds\Core\Facades\Funds;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RecurringDonationsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/Views', 'recurring-donations');
        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        $this->loadJsonTranslationsFrom(__DIR__.'/lang');

        Funds::addDonationType('recurring', 'Recurring');

        Funds::payment()->register(SepaPaymentGateway::class);

        //  resolving routes by route name only works if the route name is already matched
        Route::matched(function () {
            Funds::navigation()
                ->register(
                    title: __('Recurring Donations'),
                    routeName: 'recurring-donations.index',
                    active: request()->routeIs('recurring-donations.*'),
                );
        });

        // listen to DonationIntentCreated event
        // make a step where the donationIntent is confirmed, transfered
        // to external system and then create a donation
    }
}
