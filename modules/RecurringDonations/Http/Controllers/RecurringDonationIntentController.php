<?php

namespace Funds\RecurringDonations\Http\Controllers;

use Funds\RecurringDonations\Models\RecurringDonationIntent;

class RecurringDonationIntentController
{
    public function index()
    {
        return view('recurring-donations::intents-index', [
            'intents' => $intents = RecurringDonationIntent::unconfirmed()->get(),
            'intentsCount' => $intents->count(),
        ]);
    }

    public function confirm(RecurringDonationIntent $intent)
    {
        $intent->confirm();

        return redirect()->back();
    }
}
