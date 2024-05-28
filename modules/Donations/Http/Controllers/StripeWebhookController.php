<?php

namespace Funds\Donations\Http\Controllers;

use Funds\Donations\Models\DonationIntent;
use Illuminate\Http\Request;

class StripeWebhookController
{
    public function __invoke(Request $request)
    {
        if ($request->has('type')) {
            match ($request->type) {
                'payment_intent.succeeded' => $this->handleSucceededPaymentIntent($request->data['object']),
                default => logger()->info('Unhandled webhook type: '.$request->type),
            };
        }

        return response('Webhook Handled', 200);
    }

    private function handleSucceededPaymentIntent(array $paymentIntent): void
    {
        $intent = DonationIntent::firstWhere('payment_intent', $paymentIntent['id']);

        if (! $intent) {
            logger()->info('No donation intent found for payment intent: '.$paymentIntent['id']);

            return;
        }

        $intent->succeed();
    }
}
