<?php

namespace Funds\Donations\Http\Controllers;

use Funds\Donations\Actions\FetchPaymentMethodFromStripe;
use Funds\Donations\Models\DonationIntent;
use Illuminate\Http\Request;

class StripeWebhookController
{
    public function __invoke(Request $request)
    {
        if ($request->has('type')) {
            match ($request->type) {
                'payment_intent.succeeded' => $this->handleSucceededPaymentIntent($request->data['object']),
                'payment_intent.payment_failed' => $this->handleFailedPaymentIntent($request->data['object']),
                default => logger()->info('Unhandled webhook type: '.$request->type),
            };
        }

        return response('Webhook Handled', 200);
    }

    protected function handleSucceededPaymentIntent(array $paymentIntent): void
    {

        $intent = DonationIntent::query()->where('payment_intent', $paymentIntent['id'])->first();

        if ($intent === null) {
            logger()->info('No donation intent found for payment intent: '.$paymentIntent['id']);

            return;
        }

        // $action = FetchPaymentMethodFromStripe::class;
        // $pm = $action($paymentIntent['payment_method']);

        $intent->succeed();
    }

    protected function handleFailedPaymentIntent(array $paymentIntent): void
    {
        $intent = DonationIntent::query()->where('payment_intent', $paymentIntent['id'])->first();

        if (! $intent) {
            logger()->info('No donation intent found for payment intent: '.$paymentIntent['id']);

            return;
        }

        $intent->fail();
    }
}
