<?php

namespace Funds\Donations\Services;

use Funds\Campaign\Models\Campaign;
use Funds\Donations\DTOs\DonationIntentDto;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\Donor;
use Funds\Foundation\Contracts\DonationServiceInterface;

class DonationService implements DonationServiceInterface
{
    public function createDonationFromIntent(
        DonationIntentDto $intentData,
    ): Donation {

        $donor = $this->resolveDonor(
            $intentData->email,
            $intentData->name
        );

        $donation = new Donation();

        $donation->donor_id = $donor->id;
        $donation->amount = $intentData->amount;
        $donation->type = $intentData->type;
        $donation->campaign = Campaign::find($intentData->campaignId);
        $donation->intent_id = $intentData->id;
        $donation->receipt_address = $intentData->orderDetails['receipt_address'] ?? null;

        $donation->save();

        return $donation;
    }

    public function resolveDonor(
        $email,
        $name
    ) {
        return Donor::firstOrCreate(
            [
                'email' => $email,
            ],
            [
                'first_name' => $name,
            ]
        );

    }
}
