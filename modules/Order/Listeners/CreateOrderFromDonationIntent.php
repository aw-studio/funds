<?php

namespace Funds\Order\Listeners;

use Funds\Donations\Events\DonationIntentSucceeded;

class CreateOrderFromDonationIntent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(DonationIntentSucceeded $event): void
    {
        $event->donationIntent->donationId;

        // find donation from intent
        // create order with rewards
        // attach order to donation
    }
}
