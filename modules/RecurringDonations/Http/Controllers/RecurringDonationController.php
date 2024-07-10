<?php

namespace Funds\RecurringDonations\Http\Controllers;

use Funds\RecurringDonations\Models\RecurringDonation;
use Funds\RecurringDonations\Models\RecurringDonationIntent;

class RecurringDonationController
{
    public function index()
    {
        return view('recurring-donations::index', [
            'donations' => RecurringDonation::all(),
            'intentsCount' => RecurringDonationIntent::unconfirmed()->count(),
        ]);
    }
}
