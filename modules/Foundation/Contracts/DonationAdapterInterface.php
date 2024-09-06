<?php

namespace Funds\Foundation\Contracts;

use Funds\Donations\Models\Donation;

interface DonationAdapterInterface
{
    public function adapt(Donation $donation);
}
