<?php

namespace Funds\Donation\Payment;

use Illuminate\View\Component;
use Illuminate\View\View;

class StripePaymentElements extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('public::components.checkout.stripe-elements', [
            'publishableKey' => env('STRIPE_PUBLISHABLE_KEY'),
            'supportedDonationTypes' => StripePaymentGateway::supportedDonationTypes(),
        ]);
    }
}
