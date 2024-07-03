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

    $response = $this->get(route('public.checkout', [$campaign, $reward]));
    $response->assertStatus(200);
    expect($response->viewData('reward')->name)->toBe('Test Reward');
});

test('Donation intent is created when submitting a donation', function () {
    $campaign = Campaign::factory()->create();

    $response = $this->post(route('public.checkout.store', $campaign), [
        'donation_type' => 'onetime',
        'name' => 'Test Name',
        'amount' => 100,
        'email' => 'foo@bar.com',
        'confirmation_token' => 'payment_confirmation_token',
    ]);

    expect(DonationIntent::count())->toBe(1);
    expect(DonationIntent::first()->payment_intent)->not()->toBeNull();
    expect(DonationIntent::first()->status)->toBe('pending');
});

test('the donation intent contains the order details if a reward is selected', function () {
    $campaign = Campaign::factory()->create();
    $reward = Reward::factory()
        ->for($campaign)
        ->create();

    $this->withoutExceptionHandling();
    $response = $this->post(route('public.checkout.store', [$campaign, $reward]), [
        'donation_type' => 'onetime',
        'amount' => 100,
        'email' => 'foo@bar.com',
        'name' => 'Test Name',
        'address' => 'Test Address 27',
        'postal_code' => '1245',
        'city' => 'Test City',
        'country' => 'Test Country',
        'confirmation_token' => 'payment_confirmation_token',
        'reward_id' => $reward->id,
        'shipping_name' => 'Test Shipping',
    ]);

    expect(DonationIntent::count())->toBe(1);
    expect(DonationIntent::first()->order_details)->toBeArray();
    expect(DonationIntent::first()->order_details['reward_id'])->toBe($reward->id);
    expect(DonationIntent::first()->order_details['shipping_address']['name'])->toBe('Test Shipping');
});

test('A shipment address is required if a reward is selected', function () {
    $campaign = Campaign::factory()->create();
    $reward = Reward::factory()
        ->for($campaign)
        ->create();

    $response = $this->post(route('public.checkout.store', [$campaign, $reward]), [
        'donation_type' => 'onetime',
        'amount' => 100,
        'email' => 'foo@bar.com',
        'name' => 'Test Name',
        'address' => null,
        // 'city' => 'Test City',
        // 'country' => 'Test Country',
        'confirmation_token' => 'payment_confirmation_token',
        'reward_id' => $reward->id,
        'shipping_name' => 'Test Shipping',
    ]);

    $response->assertInvalid(['address']);
    // expect($response->assertSessionHasErrors('address'))->toBeTrue();
});
