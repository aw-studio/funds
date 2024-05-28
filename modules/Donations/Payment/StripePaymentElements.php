<?php

namespace Funds\Donations\Payment;

use Illuminate\View\Component;
use Illuminate\View\View;

class StripePaymentElements extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('donations::components.checkout.stripe-elements', [
            'publishableKey' => env('STRIPE_PUBLISHABLE_KEY'),
            'supportedDonationTypes' => StripePaymentGateway::supportedDonationTypes(),
        ]);
    }
}
