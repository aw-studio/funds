<?php

namespace Funds\Donations\Http\Controllers;

use Funds\Campaign\Models\Campaign;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Models\Donor;
use Illuminate\Http\Request;

class DonationController
{
    public function index(Request $request)
    {
        return view('donations::index',
            [
                'donations' => [],
                'pendingDonationsCount' => DonationIntent::where('status', 'pending')->count(),
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

        $donation = new Donation();
        $donation->amount = $validated['amount'];
        // session('campaign_id') is set by the EnsureCampaignMiddleware
        $donation->campaign_id = session('campaign_id');
        $donation->donor_id = $donor->id;

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
