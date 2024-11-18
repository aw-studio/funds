<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Actions\DeleteMediaByUrl;
use Funds\Campaign\Actions\ExtractRemovedImageBlocks;
use Funds\Campaign\Models\Campaign;
use Illuminate\Http\Request;

class CampaignContentController
{
    public function edit(Campaign $campaign)
    {
        return view('campaign::content.index',
            [
                'campaign' => $campaign,
            ]
        );
    }

    public function editFaq(Campaign $campaign)
    {
        return view('campaign::content.faq',
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
            'content' => 'required|string',
            'custom_css' => 'nullable|string',
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

        if ($request->input('header_image_delete') && ! $request->hasFile('header_image')) {
            $campaign->clearMediaCollection('header_image');
        }

        if ($request->input('intro_image_delete') && ! $request->hasFile('intro_image')) {
            $campaign->clearMediaCollection('intro_image');
        }

        $removedImageBlocks = $action->execute(
            json_decode($campaign->content, true),
            json_decode($request->content, true)
        );

        $campaign->update([
            'content' => $request->content,
            'description' => strip_tags($request->description),
        ]);

        foreach ($removedImageBlocks as $block) {
            app(DeleteMediaByUrl::class)->execute($campaign, $block['data']['file']['url']);
        }

        return redirect()->route('campaigns.content.edit', $campaign);
    }
}
