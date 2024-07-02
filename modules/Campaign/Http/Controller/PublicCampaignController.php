<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Models\Campaign;

class PublicCampaignController
{
    public function show(Campaign $campaign)
    {
        return view('campaigns::public.show',
            [
                'campaign' => $campaign,
            ]
        );
    }
}
