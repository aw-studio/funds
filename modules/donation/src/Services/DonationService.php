<?php

namespace Funds\Donation\Services;

use Funds\Campaign\Models\Campaign;
use Funds\Donation\DTOs\DonationIntentDto;
use Funds\Donation\Models\Donation;
use Funds\Donation\Models\Donor;
use Funds\Foundation\Contracts\DonationServiceInterface;

class DonationService implements DonationServiceInterface
{
    public function createDonationFromIntent(DonationIntentDto $intentData): Donation
    {

        $donor = $this->findOrCreateDonor(
            $intentData->email,
            $intentData->name
        );

        $donation = new Donation;

        $donation->donor_id = $donor->id;
        $donation->amount = $intentData->amount;
        $donation->type = $intentData->type;
        $donation->campaign = Campaign::find($intentData->campaignId);
        $donation->intent_id = $intentData->id;
        $donation->receipt_address = $intentData->receiptAddress;

        $donation->save();

        return $donation;
    }

    public function findOrCreateDonor(string $email, string $name)
    {
        return Donor::firstOrCreate(
            [
                'email' => $email,
            ],
            [
                'name' => $name,
            ]
        );

    }
}
