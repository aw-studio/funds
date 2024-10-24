<?php

namespace Funds\Order;

use Funds\Donation\Events\DonationIntentSucceeded;
use Funds\Order\Listeners\CreateOrderFromDonationIntent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class OrderEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        DonationIntentSucceeded::class => [
            CreateOrderFromDonationIntent::class,
        ],
    ];
}
