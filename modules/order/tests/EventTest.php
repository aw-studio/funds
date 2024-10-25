<?php

use Funds\Donation\Events\DonationIntentSucceeded;
use Funds\Order\Listeners\CreateOrderFromDonationIntent;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

uses(TestCase::class);

test('It listens to the donationIntentFinalized ', function () {
    Event::fake();

    Event::assertListening(
        DonationIntentSucceeded::class,
        CreateOrderFromDonationIntent::class
    );
});
