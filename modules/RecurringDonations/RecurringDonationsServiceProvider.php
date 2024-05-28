<?php

namespace Funds\RecurringDonations;

use Funds\Core\Facades\Funds;
use Illuminate\Support\ServiceProvider;

class RecurringDonationsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        Funds::addDonationType('recurring', 'Recurring');

        Funds::payment()->register(SepaPaymentGateway::class);

        // listen to DonationIntentCreated event
        // make a step where the donationIntent is confirmed, transfered
        // to external system and then create a donation
    }
}
