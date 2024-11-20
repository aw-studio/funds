<?php

use Funds\Campaign\Models\Campaign;
use Funds\Donation\Models\Donation;
use Funds\Donation\Models\DonationIntent;
use Funds\Donation\Models\Donor;
use Funds\Foundation\Support\Amount;
use Funds\Order\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('A donation has an amount', function () {
    $donation = new Donation([
        'amount' => 100,
    ]);

    expect($donation->amount)->toBeInstanceOf(Amount::class);
    expect($donation->amount->get())->toBe(100);
});

test('A dontation belongs to a donor', function () {
    $donation = Donation::factory()->create();

    expect($donation->donor)->toBeInstanceOf(Donor::class);
});

test('A donation may have an order of a reward', function () {
    $donation = Donation::factory()->create();
    expect($donation->order)->toBeNull();

    $order = Order::factory()->make();
    $donation->order()->save($order);

    expect($donation->refresh()->order)->not->toBeNull();
});

test('A donation returns the fee amount based on the campaign', function () {
    $campaign = Campaign::factory()->create([
        'fees' => 3,
    ]);

    $donation = Donation::factory([
        'campaign_id' => $campaign->id,
        'amount' => 2500,
    ])->for(DonationIntent::factory([
        'pays_fees' => true,
    ]))->create();

    expect($donation->paidFeeAmount()->get())->toBe(72);
});
