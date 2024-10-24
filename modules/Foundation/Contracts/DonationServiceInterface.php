<?php

namespace Funds\Foundation\Contracts;

use Funds\Donation\DTOs\DonationIntentDto;
use Funds\Donation\Models\Donation;

interface DonationServiceInterface
{
    public function createDonationFromIntent(DonationIntentDto $data): Donation;
}
