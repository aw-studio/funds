<?php

namespace Funds\Donation\Actions;

use Stripe\StripeClient;

class FetchPaymentMethodFromStripe
{
    public function execute($paymentMethodId)
    {
        $stripe = new StripeClient([
            'api_key' => config('funds.stripe.secret_key'),
        ]);

        $paymentMethod = $stripe->paymentMethod->retrieve($paymentMethodId)->type;

        return $paymentMethod;
    }
}
