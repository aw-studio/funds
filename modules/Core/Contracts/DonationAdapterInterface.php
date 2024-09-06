<?php

namespace Funds\Core\Contracts;

use Funds\Donations\Models\Donation;

interface DonationAdapterInterface
{
    public function adapt(Donation $donation);
}
