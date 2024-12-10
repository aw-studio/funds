<?php

namespace Funds\Donation\Services;

use Funds\Campaign\Models\Campaign;
use Funds\Donation\Enums\DonationType;
use Funds\Donation\Models\DonationIntent;
use Funds\Donation\Payment\PaymentResponseData;
use Funds\Foundation\Contracts\DonationIntentServiceInterface;
use Funds\Foundation\Contracts\PaymentGatewayInterface;
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
            $validatedData['pays_fees'] ?? false,
        );

        $intent->receipt_address = $this->makeReceiptAddress($validatedData);

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
                'street' => $validatedData['street'],
                'address_addition' => $validatedData['address_addition'] ?? null,
                'postal_code' => $validatedData['postal_code'],
                'city' => $validatedData['city'],
                'country' => $validatedData['country'],
            ],
        ]);
    }

    public function makeReceiptAddress(array $validatedData): ?array
    {
        if (! ($validatedData['requires_receipt'] ?? false)) {
            return null;
        }

        if ($validatedData['use_shipping_address_for_receipt'] ?? false) {
            return [
                'name' => $validatedData['shipping_name'],
                'address' => $validatedData['street'],
                'address_addition' => $validatedData['address_addition'] ?? null,
                'postal_code' => $validatedData['postal_code'],
                'city' => $validatedData['city'],
                'country' => $validatedData['country'],
            ];
        }

        return [
            'name' => $validatedData['receipt_name'],
            'address' => $validatedData['receipt_address'],
            'postal_code' => $validatedData['receipt_postal_code'],
            'city' => $validatedData['receipt_city'],
            'country' => $validatedData['receipt_country'],
        ];
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
