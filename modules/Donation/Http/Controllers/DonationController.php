<?php

namespace Funds\Donation\Http\Controllers;

use Funds\Donation\Enums\DonationIntentStatus;
use Funds\Donation\Enums\DonationType;
use Funds\Donation\Models\Donation;
use Funds\Donation\Models\DonationIntent;
use Funds\Donation\Models\Donor;
use Illuminate\Http\Request;

class DonationController
{
    public function index(Request $request)
    {
        return view('donations::index',
            [
                'donations' => collect([]),
                'pendingDonationsCount' => DonationIntent::query()->where('status', DonationIntentStatus::Pending)->count(),
            ]
        );
    }

    public function create()
    {
        return view('donations::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric',
            'reward_id' => 'nullable|exists:rewards,id',
        ]);

        $donor = Donor::firstOrCreate(['email' => $validated['email']]);

        $donation = new Donation;
        $donation->amount = $validated['amount'];
        $donation->campaign_id = $request->user()->currentCampaign->id;
        $donation->donor_id = $donor->id;
        $donation->type = DonationType::OneTime;

        $donor->donations()->save($donation);

        return redirect()->route('donations.index');
    }

    public function show(Donation $donation)
    {
        $donation->load(['donor', 'donationIntent']);

        return view('donations::show', [
            'donation' => $donation,
            'donor' => $donation->donor,
        ]);
    }
}
