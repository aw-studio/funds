<?php

namespace Funds\Donation\Listeners;

use Funds\Donation\Events\DonationIntentSucceeded;
use Funds\Donation\Models\Donation;
use Funds\Donation\Notifications\DonationReceivedNotification;

class DonationIntentSucceededListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DonationIntentSucceeded $event): void
    {
        $donation = Donation::find($event->donationIntentData->donationId);
        $donation->donor->notify(new DonationReceivedNotification($donation));
    }
}
