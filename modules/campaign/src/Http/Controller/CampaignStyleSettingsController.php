<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Actions\ExtractRemovedImageBlocks;
use Funds\Campaign\Models\Campaign;
use Illuminate\Http\Request;

class CampaignStyleSettingsController
{
    public function edit(Campaign $campaign)
    {
        return view('campaign::content.design',
            [
                'campaign' => $campaign,
            ]
        );
    }

    public function update(Request $request, Campaign $campaign, ExtractRemovedImageBlocks $action)
    {
        //
        $colors = collect($request->colors)->mapWithKeys(function ($color, $key) {
            if ($color == '#010101') {
                return [$key => null];
            }

            return [$key => $color];
        });

        $campaign->settings = [
            ...$campaign->settings ?? [],
            'custom_css' => $request->custom_css,
            'colors' => $colors,
        ];

        $campaign->save();

        flash('Style settings updated successfully', 'success');

        return redirect()->back();
    }
}
