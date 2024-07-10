<?php

namespace Funds\Donations\Http\Controllers;

use Funds\Campaign\Models\Campaign;
use Funds\Donations\Http\Requests\CheckoutDonationRequest;
use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Payment\PaymentResponseData;
use Funds\Donations\Services\DonationIntentService;
use Funds\Reward\Models\Reward;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController
{
    public function show(Request $request, Campaign $campaign, ?Reward $reward = null)
    {
        return view('donations::public.checkout', [
            'campaign' => $campaign,
            'reward' => $reward,
        ]);
    }

    public function store(
        CheckoutDonationRequest $request,
        Campaign $campaign,
        DonationIntentService $donationIntentService,
        ?Reward $reward = null,
    ) {
        $validated = $request->validated();

        // TODO: if something of this is invalid?
        if ($reward !== null) {
            $orderDetails = [
                'reward_id' => $reward->id,
                'reward_variant_id' => $validated['reward_variant_id'] ?? null,
                'shipping_address' => [
                    'name' => $validated['shipping_name'],
                    'address' => $validated['address'],
                    'address_addition' => $validated['address_addition'] ?? null,
                    'postal_code' => $validated['postal_code'],
                    'city' => $validated['city'],
                    'country' => $validated['country'],
                ],
            ];
        }

        $intent = $donationIntentService->createIntent(
            $validated['name'],
            $validated['email'],
            $validated['amount'],
            $campaign,
            $request->donation_type,
            $orderDetails ?? null,
            $validated['pays_fees'] ?? false
        );

        $responseData = $donationIntentService->processIntent(
            $intent,
            $request->paymentGateway,
            $validated
        );

        if ($responseData instanceof PaymentResponseData) {
            return new JsonResponse($responseData->data);
        }

        // todo: catch errors and prevent redirect to undefined

        return redirect()->route('public.checkout.return', [
            'campaign' => $campaign,
            'donationIntent' => $intent,
        ]);

    }

    public function return(
        Request $request,
        Campaign $campaign,
        DonationIntent $donationIntent
    ) {
        $status = $request->get('redirect_status') ?? $donationIntent->status;

        return view('donations::public.checkout-completed', [
            'campaign' => $campaign,
            'donationIntent' => $donationIntent,
            'status' => $status,
        ]);
    }
}
