<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Actions\SyncCampaignFaqs;
use Funds\Campaign\Models\Campaign;
use Illuminate\Http\Request;

class CampaignFaqController
{
    public function edit(Campaign $campaign)
    {
        return view('campaign::content.faq',
            [
                'campaign' => $campaign,
                'faqs' => $campaign->faqs()->orderBy('order')->get(),
            ]
        );
    }

    public function update(Request $request, Campaign $campaign, SyncCampaignFaqs $action)
    {
        $request->validate([
            'faqs' => 'required|array',
        ]);

        $action->execute($campaign, $request->faqs);

        flash('FAQs updated successfully', 'success');

        return redirect()->back();
    }
}
