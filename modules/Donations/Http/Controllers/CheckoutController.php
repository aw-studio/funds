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
        DonationIntentService $donationIntentService,
        ?Reward $reward = null,
    ) {
        $paymentGateway = Funds::payment()->resolve($request->input('donation_type') ?? 'onetime');

        $validated = $request->validate([
            'donation_type' => 'required',
            'amount' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'name' => ['required', 'string'],
            'pays_fees' => ['nullable', 'boolean'],
            'reward_id' => ['nullable', 'exists:rewards,id'],
            'reward_variant_id' => ['nullable', 'exists:reward_variants,id'],
            // 'shipping_address' => ['nullable', 'array', 'required_with:reward_id'],
            'shipping_name' => ['nullable', 'string'],
            // 'shipping_address.line1' => ['nullable', 'string', 'required_with:reward_id'],
            ...$paymentGateway::rules(),
        ]);

        // TODO: if something of this is invalid?
        if ($reward !== null) {
            $orderDetails = [
                'reward_id' => $reward->id,
                'reward_variant_id' => $validated['reward_variant_id'] ?? null,
                'shipping_address' => [
                    'name' => $validated['shipping_name'],
                ],
            ];
        }

        $intent = $donationIntentService->createIntent(
            $validated['email'],
            $validated['amount'],
            $campaign,
            $request->donation_type,
            $orderDetails ?? null,
            $validated['pays_fees'] ?? false
        );

        $responseData = $donationIntentService->processIntent($intent, $paymentGateway, $validated);

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
