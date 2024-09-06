<?php

use Funds\Donations\Enums\DonationType;
use Funds\Donations\Payment\StripePaymentGateway;
use Funds\Foundation\PaymentGatewayResolver;

test('It registers a payment gateway', function () {
    $resolver = new PaymentGatewayResolver();
    $resolver->register(StripePaymentGateway::class);
    expect(getProtected($resolver, 'gateways')[0])->toBe(StripePaymentGateway::class);
});

test('It resolves a payment gateway', function () {
    $resolver = new PaymentGatewayResolver();
    $resolver->register(StripePaymentGateway::class);
    $gateway = $resolver->resolve(DonationType::OneTime);
    expect($gateway)->toBeInstanceOf(StripePaymentGateway::class);
});
