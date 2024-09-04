<?php

use Funds\Campaign\Models\Campaign;
use Funds\Donations\Enums\DonationIntentStatus;
use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Tests\Support\MockStripeClient;
use Funds\Reward\Models\Reward;
use Funds\Reward\Models\RewardVariant;
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

    $this->withoutExceptionHandling();
    $response = $this->post(route('public.checkout.store', $campaign), [
        'donation_type' => 'one_time',
        'name' => 'Test Name',
        'amount' => 100,
        'email' => 'foo@bar.com',
        'confirmation_token' => 'payment_confirmation_token',
    ]);

    expect(DonationIntent::count())->toBe(1);
    expect(DonationIntent::first()->payment_intent)->not()->toBeNull();
    expect(DonationIntent::first()->status)->toBe(DonationIntentStatus::Pending);

});

test('the donation intent contains the order details if a reward is selected', function () {
    $campaign = Campaign::factory()->create();
    $reward = Reward::factory()
        ->for($campaign)
        ->create();

    $this->withoutExceptionHandling();
    $response = $this->post(route('public.checkout.store', [$campaign, $reward]), [
        'donation_type' => 'one_time',
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
test('The order details contain a reward_variant_id if a variant was selected', function () {
    $campaign = Campaign::factory()->create();
    $reward = Reward::factory()
        ->for($campaign)
        ->create();

    $response = $this->post(route('public.checkout.store', [$campaign, $reward]), [
        'donation_type' => 'one_time',
        'amount' => 100,
        'email' => 'user@user.com',
        'name' => 'Test Name',
        'address' => 'Test Address 27',
        'postal_code' => '1245',
        'city' => 'Test City',
        'country' => 'Test Country',
        'confirmation_token' => 'payment_confirmation_token',
        'reward_id' => $reward->id,
        'shipping_name' => 'Test Shipping',
        'reward_variant' => RewardVariant::factory()->create(['reward_id' => $reward->id])->id,
    ]);

    expect(DonationIntent::count())->toBe(1);
    expect(DonationIntent::first()->order_details['reward_variant_id'])->toBe(1);
});

test('A shipment address is required if a reward is selected', function () {
    $campaign = Campaign::factory()->create();
    $reward = Reward::factory()
        ->for($campaign)
        ->create();

    $response = $this->post(route('public.checkout.store', [$campaign, $reward]), [
        'donation_type' => 'one_time',
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

test('the Donation intent amount is increased by campaign fees if the user pays the fees', function () {
    $campaign = Campaign::factory(['fees' => 3])->create();

    $this->post(route('public.checkout.store', $campaign), [
        'donation_type' => 'one_time',
        'name' => 'Test Name',
        'amount' => 100,
        'email' => 'user@foo.com',
        'confirmation_token' => 'payment_confirmation_token',
        'pays_fees' => true,
    ]);

    expect(DonationIntent::count())->toBe(1);
    expect(DonationIntent::first()->amount)->toBe('103');
});
