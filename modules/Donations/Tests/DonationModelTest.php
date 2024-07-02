<?php

use Funds\Core\Support\Amount;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\Donor;
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
