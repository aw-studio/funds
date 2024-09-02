<?php

use Funds\Campaign\Models\Campaign;
use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Services\DonationIntentService;
use Funds\Reward\Models\Reward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('It creates a donation intent', function () {
    $service = new DonationIntentService();

    $intent = $service->createIntent(
        name: 'User',
        email: 'test@example.com',
        amountInCents: 1000,
        campaign: $campaign = Campaign::factory()->create(),
        type: 'onetime'
    );

    expect($intent)->toBeInstanceOf(DonationIntent::class);
    expect($intent->email)->toBe('test@example.com');
    expect($intent->amount)->toBe(1000);
    expect($intent->campaign_id)->toBe($campaign->id);
    expect($intent->type)->toBe('onetime');
    expect($intent->orderDetails)->toBeNull();

});

test('It creates a donationIntent with a reward', function () {
    $service = new DonationIntentService();
    $reward = Reward::factory()->create();
    $intent = $service->createIntent(
        name: 'User',
        email: 'test@example.com',
        amountInCents: 1000,
        campaign: $campaign = Campaign::factory()->create(),
        type: 'onetime',
        orderDetails: [
            'reward_id' => $reward->id,
        ]
    );

    expect($intent->order_details)->toHaveKey('reward_id');
    expect($intent->order_details['reward_id'])->toBe($reward->id);
});
