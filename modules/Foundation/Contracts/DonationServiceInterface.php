<?php

namespace Funds\Foundation\Contracts;

use Funds\Donations\DTOs\DonationIntentDto;
use Funds\Donations\Models\Donation;

interface DonationServiceInterface
{
    public function createDonationFromIntent(DonationIntentDto $data): Donation;

    // public function createDonation(DonationIntentDto $data): Donation;
}
