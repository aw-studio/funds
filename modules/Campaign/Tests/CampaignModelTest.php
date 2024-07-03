<?php

use Funds\Campaign\Models\Campaign;
use Funds\Core\Support\Amount;
use Funds\Donations\Models\Donation;
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

    expect($campaign->totalAmountDonated()->cents)->toBe(600);
});
