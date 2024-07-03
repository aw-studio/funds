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

        return redirect()->to($campaign->appRoute());
    }

    public function show(Request $request, Campaign $campaign)
    {
        //switch to campaign
        $request->user()->switchCurrentCampaignTo($campaign);

        return view('campaigns::show',
            [
                'campaign' => $campaign,
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
            'goal' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $campaign->update($validated);

        return redirect()->to($campaign->appRoute());
    }
}
