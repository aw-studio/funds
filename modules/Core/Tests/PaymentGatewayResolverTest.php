<?php

use Funds\Core\PaymentGatewayResolver;
use Funds\Donations\Payment\StripePaymentGateway;

test('It registers a payment gateway', function () {
    $resolver = new PaymentGatewayResolver();
    $resolver->register(StripePaymentGateway::class);
    expect(getProtected($resolver, 'gateways')[0])->toBe(StripePaymentGateway::class);
});

test('It resolves a payment gateway', function () {
    $resolver = new PaymentGatewayResolver();
    $resolver->register(StripePaymentGateway::class);
    $gateway = $resolver->resolve('onetime');
    expect($gateway)->toBeInstanceOf(StripePaymentGateway::class);
});
