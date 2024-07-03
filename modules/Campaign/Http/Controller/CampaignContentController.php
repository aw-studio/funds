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
        $campaign->content = $request->content;
        $campaign->save();

        return redirect()->route('campaigns.content.edit', $campaign);
    }
}
