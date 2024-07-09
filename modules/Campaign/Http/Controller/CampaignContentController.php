<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Models\Campaign;
use Illuminate\Http\Request;

class CampaignContentController
{
    public function edit(Campaign $campaign)
    {
        return view('campaigns::content',
            [
                'campaign' => $campaign,
            ]
        );
    }

    public function update(Request $request, Campaign $campaign)
    {
        if ($request->hasFile('header_image') && $request->file('header_image')->isValid()) {
            $campaign->addMediaFromRequest('header_image')->toMediaCollection('header_image');
        }
        $campaign->content = $request->content;
        $campaign->settings = [
            ...$campaign->settings,
            'primary_color' => $request->primary_color,
        ];
        $campaign->save();

        return redirect()->route('campaigns.content.edit', $campaign);
    }
}
