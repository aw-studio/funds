<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Models\Campaign;
use Illuminate\Http\Request;

class CampaignSettingsController
{
    public function edit(Campaign $campaign)
    {
        return view(
            'campaign::content.settings',
            [
                'campaign' => $campaign,
            ]
        );
    }

    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'custom_domain' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'social_share_text' => 'nullable|string',
        ]);

        $campaign->update([
            'custom_domain' => $request->custom_domain,
            'meta_description' => $request->meta_description,
            'social_share_text' => $request->social_share_text,
        ]);

        flash('Settings updated successfully', 'success');

        return redirect()->back();
    }
}
