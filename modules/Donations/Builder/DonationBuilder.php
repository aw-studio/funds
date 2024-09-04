<?php

namespace Funds\Donations\Builder;

use Funds\Donations\Enums\DonationType;
use Illuminate\Database\Eloquent\Builder;

class DonationBuilder extends Builder
{
    public function onetime()
    {
        return $this->where('type', DonationType::OneTime);
    }

    public function search($search)
    {
        return $this->whereHas('donor', function ($donorQuery) use ($search) {
            $donorQuery->where('email', 'like', "%$search%");
        });
    }
}
