<?php

use Funds\Donations\DTOs\DonationIntentDto;
use Funds\Donations\Events\DonationIntentSucceeded;
use Funds\Order\Listeners\CreateOrderFromDonationIntent;
use Funds\Order\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('It creates an order from a donation intent', function () {

    $listener = new CreateOrderFromDonationIntent();
    $listener->handle(new DonationIntentSucceeded(
        new DonationIntentDto(
            'user@user.com',
            100,
            1,
            null,
            [
                'reward' => 1,
            ],
            'donation'
        )
    ));
    expect(Order::count())->toBe(1);
})->todo();
