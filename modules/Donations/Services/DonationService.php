<?php

namespace Funds\Donations\Services;

use Funds\Campaign\Models\Campaign;
use Funds\Core\Contracts\DonationServiceInterface;
use Funds\Donations\DTOs\DonationIntentDto;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\Donor;

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
        // $donation->pays_fees = $intentData->paysFees;
        $donation->campaign = Campaign::find($intentData->campaignId);
        // This required?
        $donation->intent_id = $intentData->id;
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
