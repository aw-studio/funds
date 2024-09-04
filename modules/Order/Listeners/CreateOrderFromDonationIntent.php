<?php

namespace Funds\Order\Listeners;

use Funds\Donations\Events\DonationIntentSucceeded;
use Funds\Order\Models\Order;

class CreateOrderFromDonationIntent
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(DonationIntentSucceeded $event): void
    {
        if ($event->donationIntentData->orderDetails === null) {
            return;
        }

        $order = new Order();
        $order->campaign_id = $event->donationIntentData->campaignId;
        $order->donation_id = $event->donationIntentData->donationId;

        $order->reward_id = $event->donationIntentData->orderDetails['reward_id'];
        $order->reward_variant_id = $event->donationIntentData->orderDetails['reward_variant_id'] ?? null;
        $order->shipping_address = $event->donationIntentData->orderDetails['shipping_address'];

        $order->save();

        // find donation from intent
        // create order with rewards
        // attach order to donation
    }
}
