<?php

namespace Funds\Donations\Services;

use Funds\Core\Contracts\PaymentGatewayInterface;
use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Payment\PaymentResponseData;

class DonationIntentService
{
    public function createIntent($email, $amountInCents, $campaign, $type): DonationIntent
    {
        $intent = DonationIntent::make([
            'email' => $email,
            'amount' => $amountInCents,
            // 'rewards' => $request->reward_id,
        ]);

        $intent->type = $type;
        $intent->campaign = $campaign;

        $intent->save();

        return $intent;
    }

    public function processIntent(
        DonationIntent $intent,
        PaymentGatewayInterface $gateway,
        array $validated
    ) {
        $paymentIntentData = $gateway->process($intent, $validated);

        if ($paymentIntentData instanceof PaymentResponseData && isset($paymentIntentData->data['payment_intent_id'])) {
            $intent->payment_intent = $paymentIntentData->data['payment_intent_id'];
            $intent->save();
        }

        return $paymentIntentData;

    }
}
