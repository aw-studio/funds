<?php

use Funds\Campaign\Models\Campaign;
use Funds\Core\Support\Amount;
use Funds\Donations\Models\Donation;
use Funds\Order\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('A campaign has a name', function () {
    $campaign = Campaign::factory()->create([
        'name' => 'Test Campaign',
    ]);
    Donation::factory();
    expect($campaign->name)->toBe('Test Campaign');
});

test('A campaign has a description', function () {
    $campaign = Campaign::factory()->create([
        'description' => 'Test Description',
    ]);

    expect($campaign->fresh()->description)->toBe('Test Description');
});

test('A campaign has a goal amount', function () {
    $campaign = Campaign::factory()->create([
        'goal' => 1000,
    ]);

    expect($campaign->goal)->toBeInstanceOf(Amount::class);
    expect($campaign->goal->get())->toBe(1000);
});

test('A campaign can be published');

test('A campaign can have faqs');

test('A campaign can have rewards');

test('A campaign has a story');
// test('A campaign can have style settings');

test('A campaigns donations sum up to the total amount donated', function () {
    $campaign = Campaign::factory()->create();

    Donation::factory()
        ->for($campaign)
        ->count(3)
        ->create([
            'amount' => 200,
        ]);
    // total_donated is only avaialble when the global scope is applied
    $campaign = Campaign::first();
    expect($campaign->totalAmountDonated()->cents)->toBe(600);
});

test('The campaign progress is calculated based on the total amount donated and the goal', function () {
    $campaign = Campaign::factory()->create([
        'goal' => 1000,
    ]);

    Donation::factory()
        ->for($campaign)
        ->count(3)
        ->create([
            'amount' => 200,
        ]);

    // total_donated is only avaialble when the global scope is applied
    $campaign = Campaign::first();

    expect($campaign->progress())->toBe(60);
});

// public function orderDonationCount()
// {
//     return $this->donations()->whereHas('order')->count();
// }

// public function noOrderDonationCount()
// {
//     return $this->donations()->whereDoesntHave('order')->count();
// }

test('A campaign can count donations with an order', function () {
    $campaign = Campaign::factory()->create();

    Donation::factory()
        ->for($campaign)
        ->has(Order::factory())
        ->count(3)
        ->create([
            'amount' => 200,
        ]);

    Donation::factory()
        ->for($campaign)
        ->count(2)
        ->create([
            'amount' => 200,
        ]);

    expect($campaign->orderDonationCount())->toBe(3);
});

test('A campaign can count donations without an order', function () {
    $campaign = Campaign::factory()->create();

    Donation::factory()
        ->for($campaign)
        ->has(Order::factory())
        ->count(3)
        ->create([
            'amount' => 200,
        ]);

    Donation::factory()
        ->for($campaign)
        ->count(2)
        ->create([
            'amount' => 200,
        ]);

    expect($campaign->noOrderDonationCount())->toBe(2);
});

test('A camapaigns total_donated is loaded by default', function () {
    $campaign = Campaign::factory()->create();

    Donation::factory()
        ->for($campaign)
        ->count(3)
        ->create([
            'amount' => 200,
        ]);

    expect(Campaign::first()->total_donated)->toBe(600);
    expect(Campaign::first()->totalAmountDonated())->toEqual(new Amount(600));
});
