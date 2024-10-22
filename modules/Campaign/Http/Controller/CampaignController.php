<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Models\Campaign;
use Funds\Foundation\Support\Amount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CampaignController
{
    public function index()
    {
        return view('campaigns::index',
            [
                'campaigns' => Campaign::withCount('donations')
                    ->get(),
            ]
        );
    }

    public function create()
    {
        return view('campaigns::create');
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

        $validated['slug'] = Str::slug($validated['name']);

        $campaign = Campaign::create($validated);

        return redirect()->to($campaign->appRoute());
    }

    public function show(Request $request, Campaign $campaign)
    {
        //switch to campaign
        $request->user()->switchCurrentCampaignTo($campaign);

        $adjustedTotalAmount = $campaign->total_donated * (1 - $campaign->fees / 100);
        $adjustedTotalAmount = new Amount((int) $adjustedTotalAmount);

        $rewards = $campaign->topRewards()->get();

        return view('campaigns::show',
            [
                'campaign' => $campaign,
                'adjustedTotalAmount' => $adjustedTotalAmount,
                'rewards' => $rewards,
            ]
        );
    }

    public function edit(Request $request, Campaign $campaign)
    {
        return view('campaigns::edit',
            [
                'campaign' => $campaign,
            ]
        );
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
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $campaign->update($validated);

        flash('Campaign updated!', 'success');

        return redirect()->route('campaigns.show', ['campaign' => $campaign]);
    }
}
