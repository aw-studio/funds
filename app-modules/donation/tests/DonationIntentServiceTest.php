<?php

use Funds\Campaign\Models\Campaign;
use Funds\Donation\Enums\DonationType;
use Funds\Donation\Models\DonationIntent;
use Funds\Donation\Services\DonationIntentService;
use Funds\Reward\Models\Reward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('It creates a donation intent', function () {
    $service = new DonationIntentService;

    $intent = $service->createDonationIntent(
        $validatedData = [
            'name' => 'User',
            'email' => 'test@example.com',
            'amount' => 1000,

        ],
        $campaign = Campaign::factory()->create(),
        null
    );

    expect($intent)->toBeInstanceOf(DonationIntent::class);
    expect($intent->email)->toBe('test@example.com');
    expect($intent->amount)->toBe(1000);
    expect($intent->campaign_id)->toBe($campaign->id);
    expect($intent->type)->toBe(DonationType::OneTime);
    expect($intent->orderDetails)->toBeNull();
});

test('It creates a donationIntent with a reward order', function () {
    $service = new DonationIntentService;
    $reward = Reward::factory()->create();
    $intent = $service->createDonationIntent(
        validatedData: $validatedData = [
            'name' => 'User',
            'email' => 'user@example.org',
            'amount' => 1000,
            'shipping_name' => 'User foo',
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'NY',
            'postal_code' => '12345',
            'country' => 'US',
        ],
        campaign: $campaign = Campaign::factory()->create(),
        reward: $reward
    );

    expect($intent->order_details)->toHaveKey('reward_id');
    expect($intent->order_details['reward_id'])->toBe($reward->id);
});
