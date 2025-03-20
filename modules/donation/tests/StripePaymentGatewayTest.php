<?php

use Funds\Donation\Enums\DonationType;
use Funds\Donation\Models\DonationIntent;
use Funds\Donation\Payment\PaymentResponseData;
use Funds\Donation\Payment\StripePaymentGateway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\Service\PaymentIntentService;
use Stripe\StripeClient;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
test('the stripe payment gateway can be used for onetime donations', function () {
    expect(StripePaymentGateway::canBeUsedFor(DonationType::OneTime))->toBeTrue();
    expect(StripePaymentGateway::canBeUsedFor(DonationType::Recurring))->toBeFalse();
});

test('the stripe payment gateway supports onetime donations', function () {
    expect(StripePaymentGateway::supportedDonationTypes())->toHaveAttribute(DonationType::OneTime);
})->todo('attribute should be string');

test('the stripe payment gateway validation rules include confirmation_token', function () {
    expect(StripePaymentGateway::rules())->toHaveKey('confirmation_token');
});

test('processing a donation intent creates a payment intent', function () {
    $intent = DonationIntent::factory()->make([
        'amount' => 1000,
    ]);

    $intent->id = '1';

    $stripe = Mockery::mock(StripeClient::class);
    $paymentIntentService = Mockery::mock(PaymentIntentService::class);

    $stripe->shouldReceive('paymentIntents')
        ->andReturn($paymentIntentService);

    $returnUrl = route('public.checkout.return', [
        'campaign' => $intent->campaign,
        'donationIntent' => $intent,
    ]);

    $paymentIntentService->shouldReceive('create')
        ->with([
            'confirm' => true,
            'amount' => 1000,
            'currency' => 'eur',
            'confirmation_token' => 'my-confirmation-token',
            'return_url' => $returnUrl,
        ])
        ->andReturn((object) [
            'id' => 'payment-intent-id',
            'client_secret' => 'client-secret',
            'status' => 'requires_confirmation',
        ]);

    $stripe->shouldReceive('getService')
        ->andReturn($paymentIntentService);

    $gateway = new StripePaymentGateway($stripe);
    $response = $gateway->process($intent, ['confirmation_token' => 'my-confirmation-token']);

    expect($response)->toBeInstanceOf(PaymentResponseData::class);
    expect($response->data)->toHaveKey('payment_intent_id');
    expect($response->data['payment_intent_id'])->toBe('payment-intent-id');
    expect($response->data)->toHaveKey('client_secret');
    expect($response->data['client_secret'])->toBe('client-secret');
    expect($response->data)->toHaveKey('status');
    expect($response->data['status'])->toBe('requires_confirmation');
    expect($response->data)->toHaveKey('return_url');
    expect($response->data['return_url'])->toBe($returnUrl);
});
