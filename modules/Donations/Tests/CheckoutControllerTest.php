<?php

use Funds\Campaign\Models\Campaign;
use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Tests\Support\MockStripeClient;
use Funds\Reward\Models\Reward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\ApiRequestor;
use Stripe\Stripe;
use Tests\TestCase;

beforeEach(function () {
    Stripe::setApiKey('stripe_key');
    $mockClient = new MockStripeClient;
    ApiRequestor::setHttpClient($mockClient);
});
uses(TestCase::class, RefreshDatabase::class);

test('It renders a checkout screen for a selected reward', function () {
    $campaign = Campaign::factory()->create();
    $reward = Reward::factory()
        ->for($campaign)
        ->create([
            'name' => 'Test Reward',
        ]);

    $this->withoutExceptionHandling();
    $response = $this->get(route('public.checkout', [$campaign, $reward]));
    $response->assertStatus(200);
    expect($response->viewData('reward')->name)->toBe('Test Reward');
});

test('Donation intent is created when submitting a donation', function () {
    $campaign = Campaign::factory()->create();

    $response = $this->post(route('public.checkout.store', $campaign), [
        'donation_type' => 'onetime',
        'amount' => 100,
        'email' => 'foo@bar.com',
        'confirmation_token' => 'confirmation_token_from_frontend',
    ]);

    expect(DonationIntent::count())->toBe(1);
    expect(DonationIntent::first()->payment_intent)->not()->toBeNull();
    expect(DonationIntent::first()->status)->toBe('pending');
});
