<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Actions\ResolvePublicCampaignIndex;
use Funds\Campaign\Actions\ShowPublicCampaign;
use Funds\Campaign\Models\Campaign;
use Illuminate\Http\Request;

class PublicCampaignController
{
    public function index(ResolvePublicCampaignIndex $resolvePublicCampaignIndex)
    {
        return $resolvePublicCampaignIndex();
    }

    public function show(Request $request, Campaign $campaign, ShowPublicCampaign $showPublicCampaign)
    {
        if (config('funds.single_campaign_mode') && $request->user() == null) {
            return redirect()->route('campaigns.public.index');
        }

        return $showPublicCampaign($campaign);
    }

    public function rewards(Campaign $campaign)
    {
        return view(
            'campaign::public.rewards',
            [
                'campaign' => $campaign,
                'donation_options' => $campaign->rewards->where('is_active')->sortBy('order'),
            ]
        );
    }
}
