<?php

namespace Funds\Donation\Http\Controllers;

use Funds\Campaign\Models\Campaign;
use Funds\Donation\Http\Requests\CheckoutDonationRequest;
use Funds\Donation\Models\DonationIntent;
use Funds\Donation\Payment\PaymentResponseData;
use Funds\Foundation\Facades\Funds;
use Funds\Reward\Models\Reward;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Countries;

class CheckoutController
{
    public function show(Request $request, Campaign $campaign, ?Reward $reward = null)
    {
        $countries = Countries::getNames(app()->getLocale());

        if ($reward && ! $reward->isAvailable()) {
            $reward = null;
        }

        return view('donation::public.checkout', [
            'countries' => $countries,
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

        $service = Funds::intentHandler();

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

        return view('donation::public.checkout-completed', [
            'campaign' => $campaign,
            'donationIntent' => $donationIntent,
            'status' => $status,
        ]);
    }
}
