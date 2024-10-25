<?php

namespace Funds\Donation\Http\Controllers;

use Funds\Donation\Models\DonationIntent;
use Illuminate\Http\Request;

class DonationIntentController
{
    public function index(Request $request)
    {
        return view('donation::intents.index', [
            'intents' => DonationIntent::query()
                ->orderBy('created_at', 'desc')
                ->when($request->has('recurring'), function ($query) {
                    $query->where('type', 'recurring');
                })
                ->when(! $request->has('all'), function ($query) {
                    $query->where('status', 'pending');
                })
                ->get(),
        ]);
    }

    public function show(DonationIntent $intent)
    {
        return view('donation::intents.show', [
            'intent' => $intent,
        ]);
    }
}
