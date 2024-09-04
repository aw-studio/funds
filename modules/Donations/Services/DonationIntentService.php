<?php

namespace Funds\Donations\Services;

use Funds\Campaign\Models\Campaign;
use Funds\Core\Contracts\DonationIntentServiceInterface;
use Funds\Core\Contracts\PaymentGatewayInterface;
use Funds\Donations\Enums\DonationType;
use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Payment\PaymentResponseData;
use Funds\Order\DTOs\OrderDetailsData;
use Funds\Reward\Models\Reward;

class DonationIntentService implements DonationIntentServiceInterface
{
    public function createDonationIntent(
        array $validatedData,
        Campaign $campaign,
        ?Reward $reward
    ): DonationIntent {

        $intent = $this->makeDonationIntent(
            $validatedData['email'],
            $validatedData['name'],
            $campaign,
            $this->makeOrderDetails($reward, $validatedData),
            $validatedData['pays_fees'] ?? false
        );

        $intent->amount = $this->getAmountWithFees(
            $validatedData['amount'],
            $validatedData['pays_fees'] ?? false,
            $campaign
        );

        $intent->save();

        return $intent;
    }

    public function makeDonationIntent(
        string $email,
        string $name,
        Campaign $campaign,
        ?OrderDetailsData $orderDetails,
        bool $paysFees
    ): DonationIntent {

        $intent = new DonationIntent([
            'email' => $email,
            'name' => $name,
        ]);

        $intent->order_details = $orderDetails?->toArray();
        $intent->type = DonationType::OneTime;
        $intent->campaign = $campaign;
        $intent->pays_fees = $paysFees;

        return $intent;
    }

    public function makeOrderDetails(
        ?Reward $reward,
        array $validatedData
    ): ?OrderDetailsData {

        if (! $reward) {
            return null;
        }

        return OrderDetailsData::from([
            'reward_id' => $reward->id,
            'reward_variant_id' => $validatedData['reward_variant'] ?? null,
            'shipping_address' => [
                'name' => $validatedData['shipping_name'],
                'address' => $validatedData['address'],
                'address_addition' => $validatedData['address_addition'] ?? null,
                'postal_code' => $validatedData['postal_code'],
                'city' => $validatedData['city'],
                'country' => $validatedData['country'],
            ],
        ]);
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
    ): PaymentResponseData|bool {
        $paymentIntentData = $gateway->process($intent, $validated);

        if ($paymentIntentData instanceof PaymentResponseData && isset($paymentIntentData->data['payment_intent_id'])) {
            $intent->payment_intent = $paymentIntentData->data['payment_intent_id'];
            $intent->save();
        }

        return $paymentIntentData;

    }
}
