<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController
{
    public function index()
    {
        return view('campaigns::index',
            [
                'campaigns' => Campaign::all(),
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
            'goal' => 'required|numeric',
        ]);

        $campaign = Campaign::create($validated);

        return redirect()->route($campaign->appRoute());
    }

    public function show(Campaign $campaign)
    {
        //switch to campaign
        auth()->user()->current_campaign_id = $campaign->id;
        auth()->user()->save();

        return view('campaigns::show',
            [
                'campaign' => $campaign,
            ]
        );
    }
}
