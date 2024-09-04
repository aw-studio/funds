<?php

namespace Funds\Donations\Http\Controllers;

use Funds\Campaign\Models\Campaign;
use Funds\Core\Facades\Funds;
use Funds\Donations\Enums\DonationType;
use Funds\Donations\Http\Requests\CheckoutDonationRequest;
use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Payment\PaymentResponseData;
use Funds\Reward\Models\Reward;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController
{
    public function show(Request $request, Campaign $campaign, ?Reward $reward = null)
    {
        return view('donations::public.checkout', [
            'countries' => [
                'DE' => 'Germany',
                'AT' => 'Austria',
                'CH' => 'Switzerland',
            ],
            'campaign' => $campaign,
            'reward' => $reward,
        ]);
    }

    public function store(
        CheckoutDonationRequest $request,
        Campaign $campaign,
        ?Reward $reward = null,
    ) {
        $validated = $request->validated();

        $service = Funds::resolveIntentHandler(
            DonationType::tryFrom($validated['donation_type'])
        );

        $intent = $service->createDonationIntent(
            $validated,
            $campaign,
            $reward
        );

        $responseData = $service->processIntent(
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
