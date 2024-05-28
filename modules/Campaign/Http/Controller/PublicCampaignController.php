<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Models\Campaign;

class PublicCampaignController
{
    public function show($id)
    {
        //TODO why is route model binding not working?
        $campaign = Campaign::findOrFail($id);

        return view('campaigns::public.show',
            [
                'campaign' => $campaign,
            ]
        );
    }
}
