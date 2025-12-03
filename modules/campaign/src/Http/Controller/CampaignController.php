<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Models\Campaign;
use Funds\Foundation\Support\Amount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignController
{
    public function index()
    {

        return view('campaign::index', [
            'campaigns' => Campaign::withCount('donations')->get(),
        ]);
    }

    public function create()
    {
        return view('campaign::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'goal' => 'required|numeric|min:1',
            'fees' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // TODO: Unique slug
        $validated['slug'] = Str::slug($validated['name']);

        $campaign = Campaign::create($validated);

        return redirect()->to($campaign->appRoute());
    }

    public function show(Request $request, Campaign $campaign)
    {
        $campaign->loadCount('donations');
        $campaign->loadAvg('donations', 'amount');

        //switch to campaign
        $request->user()->switchCurrentCampaignTo($campaign);

        $adjustedTotalAmount = ($campaign->total_donated ?? 0) * (1 - ($campaign->fees ?? 0) / 100);
        $adjustedTotalAmount = new Amount((int) $adjustedTotalAmount);

        return view(
            'campaign::show',
            [
                'campaign' => $campaign,
                'adjustedTotalAmount' => $adjustedTotalAmount,
                'rewards' => [],
                'averageDonationAmount' => new Amount($campaign->donations_avg_amount ?? 0),
            ]
        );
    }

    public function edit(Request $request, Campaign $campaign)
    {
        return view('campaign::edit', [
            'campaign' => $campaign,
        ]);
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'goal' => 'required|numeric|min:1',
            'fees' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if (! $campaign->isPublished()) {
            // TODO: Unique slug
            $validated['slug'] = Str::slug($validated['name']);
        }

        $campaign->update($validated);

        flash('Campaign updated!', 'success');

        return redirect()->route('campaigns.show', ['campaign' => $campaign]);
    }
}
