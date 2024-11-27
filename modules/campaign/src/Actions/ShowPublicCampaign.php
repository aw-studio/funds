<?php

namespace Funds\Campaign\Actions;

use Funds\Campaign\Models\Campaign;

class ShowPublicCampaign
{
    public function __invoke(Campaign $campaign)
    {
        if (! $campaign->isPublic() && ! auth()->check()) {
            return response()->view('public::404', [], 404);
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
}
