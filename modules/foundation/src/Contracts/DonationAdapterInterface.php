<?php

namespace Funds\Foundation\Contracts;

use Funds\Donation\Models\Donation;

interface DonationAdapterInterface
{
    public function adapt(Donation $donation);
}
