<?php

namespace Funds\Donations\Models;

use Funds\Core\Facades\Funds;
use Funds\Core\Support\Amount;
use Illuminate\Database\Eloquent\Collection;

class DonationCollection extends Collection
{
    public function __construct($items = [])
    {
        // Resolve additional integrations
        $items = array_map(function ($item) {
            return Funds::donationResolver()->resolve($item);
        }, $items);

        parent::__construct($items);
    }

    public function totalAmount(): Amount
    {
        return new Amount($this->sum('amount.cents'));
    }
}
