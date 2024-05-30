<?php

namespace Funds\Donations\Http\Controllers;

use Funds\Campaign\Models\Campaign;
use Funds\Core\Facades\Funds;
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
        Request $request,
        Campaign $campaign,
        DonationIntentService $donationIntentService
    ) {
        $paymentGateway = Funds::payment()->resolve($request->input('donation_type') ?? 'onetime');

        $validated = $request->validate([
            'donation_type' => 'required',
            'amount' => 'required',
            'email' => ['required', 'email'],
            ...$paymentGateway::rules(),
        ]);

        $intent = $donationIntentService->createIntent(
            $validated['email'],
            $validated['amount'],
            $campaign,
            $request->donation_type
        );

        $responseData = $donationIntentService->processIntent($intent, $paymentGateway, $validated);

        if ($responseData instanceof PaymentResponseData) {
            return new JsonResponse($responseData->data);
        }

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
