<?php

namespace Funds\Donations\Services;

use Funds\Campaign\Models\Campaign;
use Funds\Core\Contracts\PaymentGatewayInterface;
use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Payment\PaymentResponseData;

class DonationIntentService
{
    public function createIntent(
        string $name,
        string $email,
        $amountInCents,
        Campaign $campaign,
        $type,
        ?array $orderDetails = null,
        bool $paysFees = false
    ): DonationIntent {

        $intent = new DonationIntent([
            'email' => $email,
            'name' => $name,
        ]);

        $intent->order_details = $orderDetails;
        $intent->type = $type;
        $intent->campaign = $campaign;
        $intent->pays_fees = $paysFees;

        $intent->amount = $this->getAmountWithFees(
            $amountInCents,
            $paysFees,
            $campaign
        );

        $intent->save();

        return $intent;
    }

    public function getAmountWithFees(
        int $amountInCents,
        bool $paysFees,
        Campaign $campaign
    ): int {

        if (! $paysFees) {
            return $amountInCents;
        }

        $fees = $campaign->fees ?? 0;
        $feeAmount = $amountInCents * $fees / 100;

        return $amountInCents + $feeAmount;
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
