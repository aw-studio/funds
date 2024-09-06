<?php

namespace Funds\Donations\Models;

use Funds\Foundation\Contracts\DonationAdapterInterface;
use Funds\Foundation\Support\Amount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;

class DonationCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct($items);

        // Resolve additional integrations
        if (App::bound(DonationAdapterInterface::class)) {
            $this->items = array_map(function ($item) {
                return App::make(DonationAdapterInterface::class)->adapt($item);
            }, $items);
        }
    }

    public function totalAmount(): Amount
    {
        return new Amount($this->sum('amount.cents'));
    }
}
