<?php

namespace Funds\RecurringDonations\Actions;

use Funds\Donations\Models\DonationIntent;

class CreateRecurringDonationIntent
{
    public function handle(
        DonationIntent $intent,
        array $validatedData
    ) {

        // $intent->recurring = true;
        // $intent->save();
        $frequency = 'monthly';

        $divider = match ($frequency) {
            'monthly' => 12,
            'quarterly' => 4,
            'yearly' => 1,
        };

        $amount = $intent->amount / $divider;

        $intent->recurring_donation_data = [
            'frequency' => 'monthly',
            'amount' => $amount,
            'payment' => [
                'method' => 'sepa',
                'iban' => $validatedData['iban'],
                'account_holder' => '',
            ],
        ];

        $intent->save();

        return $intent;

    }
}
