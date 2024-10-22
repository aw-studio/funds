<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Models\Campaign;

class PublicCampaignController
{
    public function show(Campaign $campaign)
    {
        if (! $campaign->status->isPublic() && ! auth()->check()) {
            return view('campaigns::public.404');
        }

        $campaign->loadCount('donations');

        return view('campaigns::public.show',
            [
                'campaign' => $campaign,
                'donation_options' => $campaign->rewards,
                'faqs' => $campaign->faqs,
            ]
        );
    }

    public function rewards(Campaign $campaign)
    {
        return view('campaigns::public.rewards',
            [
                'campaign' => $campaign,
                'donation_options' => $campaign->rewards,
            ]
        );
    }
}
