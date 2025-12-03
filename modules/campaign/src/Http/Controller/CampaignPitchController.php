<?php

namespace Funds\Campaign\Http\Controller;

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

    public function store(Request $request, Campaign $campaign)
    {
        $request->validate([
            'description' => 'nullable|string',
            'youtube_id' => 'nullable|string',
            'header_image' => 'nullable|image|max:5000',
            'intro_image' => 'nullable|image|max:5000',
            'pitch_video' => 'nullable|file|mimetypes:video/*|max:50000',
            'show_progress' => 'nullable|boolean',
            'og_image' => 'nullable|image|max:5000',
            'twitter_image' => 'nullable|image|max:5000',
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

        if ($request->hasFile('og_image') && $request->file('og_image')->isValid()) {
            $campaign->addMediaFromRequest('og_image')
                ->withResponsiveImages()
                ->toMediaCollection('og_image');
        }

        if ($request->hasFile('twitter_image') && $request->file('twitter_image')->isValid()) {
            $campaign->addMediaFromRequest('twitter_image')
                ->withResponsiveImages()
                ->toMediaCollection('twitter_image');
        }

        if ($request->input('header_image_delete')) {
            $campaign->clearMediaCollection('header_image');
        }

        if ($request->input('intro_image_delete')) {
            $campaign->clearMediaCollection('intro_image');
        }
        if ($request->input('og_image_delete')) {
            $campaign->clearMediaCollection('og_image');
        }
        if ($request->input('twitter_image_delete')) {
            $campaign->clearMediaCollection('twitter_image');
        }

        $campaign->update([
            'description' => strip_tags($request->description),
            'youtube_id' => $request->youtube_id,
            'settings->show_progress' => $request->boolean('show_progress'),
        ]);

        flash(__('Campaign updated successfully'), 'success');

        return redirect()->back()->with('success', 'Pitch updated successfully');
    }
}
