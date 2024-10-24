<?php

namespace Funds\Donation\Actions;

use Stripe\StripeClient;

class FetchPaymentMethodFromStripe
{
    public function execute($paymentMethodId)
    {
        $stripe = new StripeClient([
            'api_key' => env('STRIPE_SECRET_KEY'),
        ]);

        $paymentMethod = $stripe->paymentMethod->retrieve($paymentMethodId)->type;

        return $paymentMethod;
    }
}
