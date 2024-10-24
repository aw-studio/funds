<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Models\Campaign;

class PublicCampaignController
{
    public function show(Campaign $campaign)
    {
        if (! $campaign->isPublic() && ! auth()->check()) {
            return view('campaign::public.404');
        }

        $campaign->loadCount('donations');

        return view('campaign::public.show',
            [
                'campaign' => $campaign,
                'donation_options' => $campaign->rewards,
                'faqs' => $campaign->faqs,
            ]
        );
    }

    public function rewards(Campaign $campaign)
    {
        return view('campaign::public.rewards',
            [
                'campaign' => $campaign,
                'donation_options' => $campaign->rewards,
            ]
        );
    }
}
