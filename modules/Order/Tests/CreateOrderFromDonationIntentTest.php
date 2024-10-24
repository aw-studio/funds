<?php

use Funds\Donation\Events\DonationIntentSucceeded;
use Funds\Donation\Models\Donation;
use Funds\Donation\Models\DonationIntent;
use Funds\Order\Listeners\CreateOrderFromDonationIntent;
use Funds\Order\Models\Order;
use Funds\Reward\Models\Reward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('It creates an order from a donation intent', function () {

    $intent = DonationIntent::factory()
        ->has(Donation::factory())
        ->create([
            'email' => 'user@user.com',
            'amount' => 1000,
            'order_details' => [
                'reward_id' => Reward::factory()->create()->id,
                'reward_variant_id' => null,
                'shipping_address' => '123 Fake St',
            ],
        ]);

    $listener = new CreateOrderFromDonationIntent;
    $listener->handle(new DonationIntentSucceeded(
        $intent->asDto()
    ));
    expect(Order::count())->toBe(1);
});
