<?php

use Funds\Donation\Enums\DonationType;
use Funds\Donation\Payment\StripePaymentGateway;
use Funds\Foundation\PaymentGatewayResolver;
use Tests\TestCase;

uses(TestCase::class);
test('It registers a payment gateway', function () {
    $resolver = new PaymentGatewayResolver;
    $resolver->register(StripePaymentGateway::class);
    expect(getProtected($resolver, 'gateways')[0])->toBe(StripePaymentGateway::class);
});

test('It resolves a payment gateway', function () {
    $resolver = new PaymentGatewayResolver;
    $resolver->register(StripePaymentGateway::class);
    $gateway = $resolver->resolve(DonationType::OneTime);
    expect($gateway)->toBeInstanceOf(StripePaymentGateway::class);
});
