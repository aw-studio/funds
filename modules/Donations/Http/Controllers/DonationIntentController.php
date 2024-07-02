<?php

namespace Funds\Donations\Http\Controllers;

use Funds\Donations\Models\DonationIntent;

class DonationIntentController
{
    public function index()
    {
        return view('donations::intents.index', [
            'intents' => DonationIntent::query()
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }
}
