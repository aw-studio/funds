<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Actions\ExtractRemovedImageBlocks;
use Funds\Campaign\Models\Campaign;
use Illuminate\Http\Request;

class CampaignPitchController
{
    public function edit(Campaign $campaign)
    {
        return view('campaign::content.pitch',
            [
                'campaign' => $campaign,
            ]
        );
    }

    public function update(Request $request, Campaign $campaign, ExtractRemovedImageBlocks $action)
    {
        // validate
        $request->validate([
            'description' => 'required|string',
            'header_image' => 'nullable|image|max:5000',
            'intro_image' => 'nullable|image|max:5000',
            'pitch_video' => 'nullable|file|mimetypes:video/*|max:50000',
        ]);

        if ($request->hasFile('pitch_video') && $request->file('pitch_video')->isValid()) {
            $campaign->addMediaFromRequest('pitch_video')
                ->toMediaCollection('pitch_video');
        }

        if ($request->hasFile('header_image') && $request->file('header_image')->isValid()) {
            $campaign->addMediaFromRequest('header_image')
                ->withResponsiveImages()
                ->toMediaCollection('header_image');
        }

        if ($request->hasFile('intro_image') && $request->file('intro_image')->isValid()) {
            $campaign->addMediaFromRequest('intro_image')
                ->withResponsiveImages()
                ->toMediaCollection('intro_image');
        }

        if ($request->input('header_image_delete')) {
            $campaign->clearMediaCollection('header_image');
        }

        if ($request->input('intro_image_delete')) {
            $campaign->clearMediaCollection('intro_image');
        }

        $campaign->update([
            'description' => strip_tags($request->description),
        ]);

        return redirect()->back()->with('success', 'Pitch updated successfully');
    }
}
