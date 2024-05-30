<?php

namespace Funds\Donations\Payment;

use Funds\Core\Contracts\PaymentGatewayInterface;
use Funds\Donations\Models\DonationIntent;
use Stripe\Exception\ApiErrorException;

class StripePaymentGateway implements PaymentGatewayInterface
{
    public $stripe;

    public static function canBeUsedFor(string $type): bool
    {
        if (! in_array($type, self::supportedDonationTypes())) {
            return false;
        }

        return true;
    }

    public static function supportedDonationTypes(): array
    {
        return [
            'onetime',
        ];
    }

    public static function rules(): array
    {
        return [
            'confirmation_token' => 'required|string',
        ];
    }

    public function __construct($stripe = null)
    {
        if ($stripe === null) {
            $stripe = new \Stripe\StripeClient([
                'api_key' => env('STRIPE_SECRET_KEY'),
            ]);
        }

        $this->stripe = $stripe;
    }

    public function process(DonationIntent $intent, array $validatedData): PaymentResponseData
    {
        $validated = $validatedData;

        try {
            $paymentIntent = $this->stripe->paymentIntents->create([
                'confirm' => true,
                'amount' => $intent->amount,
                'currency' => 'eur',
                'confirmation_token' => $validated['confirmation_token'],
                'return_url' => $returnUrl = route('public.checkout.return', [
                    'campaign' => $intent->campaign,
                    'donationIntent' => $intent,
                ]),
            ]);

            return new PaymentResponseData([
                'payment_intent_id' => $paymentIntent->id,
                'client_secret' => $paymentIntent->client_secret,
                'status' => $paymentIntent->status,
                'return_url' => $returnUrl,
            ]);

        } catch (ApiErrorException $e) {

            return new PaymentResponseData([
                'error' => [
                    'message' => $e->getError()->message,
                    'code' => $e->getError()->code,
                ],
            ]);
        }
    }
}
