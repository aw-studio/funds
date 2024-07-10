<?php

namespace Funds\RecurringDonations\Models;

use Funds\Donations\Models\Donation;

class RecurringDonation extends Donation
{
    public $table = 'donations';

    public static function booted()
    {
        static::addGlobalScope('recurring', function ($query) {
            $query->where('type', 'recurring');
        });
    }
}
