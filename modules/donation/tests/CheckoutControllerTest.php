<?php

use Funds\Campaign\Models\Campaign;
use Funds\Donation\Enums\DonationIntentStatus;
use Funds\Donation\Models\DonationIntent;
use Funds\Donation\Tests\Support\MockStripeClient;
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
        'street' => 'Test Address 27',
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
        'street' => 'Test Address 27',
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
        'street' => null,
        // 'city' => 'Test City',
        // 'country' => 'Test Country',
        'confirmation_token' => 'payment_confirmation_token',
        'reward_id' => $reward->id,
        'shipping_name' => 'Test Shipping',
    ]);

    $response->assertInvalid(['street']);
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

test('A receipt address is required when a receipt is required', function () {
    $campaign = Campaign::factory()->create();
    $reward = Reward::factory()
        ->for($campaign)
        ->create();

    // $this->withoutExceptionHandling();
    /**
     * @var \Illuminate\Testing\TestResponse $response
     */
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
        'requires_receipt' => true,
    ]);

    $response->assertInvalid([
        'receipt_name',
        'receipt_address',
        'receipt_postal_code',
        'receipt_city',
        'receipt_country',
    ]);

});

test('A receipt_address is not required if the shipping address should be used ', function () {
    $campaign = Campaign::factory()->create();
    $reward = Reward::factory()
        ->for($campaign)
        ->create();

    // $this->withoutExceptionHandling();
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
        'requires_receipt' => true,
        'use_shipping_address_for_receipt' => true,
    ]);

    $response->assertValid([
        'receipt_name',
        'receipt_address',
        'receipt_postal_code',
        'receipt_city',
        'receipt_country',
    ]);
});

test('DonationIntent contains receipt address', function () {
    $campaign = Campaign::factory()->create();

    $response = $this->post(route('public.checkout.store', [$campaign]), [
        'donation_type' => 'one_time',
        'amount' => 100,
        'email' => 'foo@test.com',
        'name' => 'Test Name',
        'confirmation_token' => 'payment_confirmation_token',
        'requires_receipt' => true,
        'use_shipping_address_for_receipt' => false,
        'receipt_name' => 'Test Receipt',
        'receipt_address' => 'Test Receipt Address 27',
        'receipt_postal_code' => '1245',
        'receipt_city' => 'Test Receipt City',
        'receipt_country' => 'Test Receipt Country',
    ]);

    expect(DonationIntent::count())->toBe(1);
    expect(DonationIntent::first()->receipt_address)->toBe([
        'name' => 'Test Receipt',
        'address' => 'Test Receipt Address 27',
        'postal_code' => '1245',
        'city' => 'Test Receipt City',
        'country' => 'Test Receipt Country',
    ]);
});
