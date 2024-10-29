<?php

namespace Funds\Campaign\Http\Controller;

use Funds\Campaign\Actions\DeleteMediaByUrl;
use Funds\Campaign\Actions\ExtractRemovedImageBlocks;
use Funds\Campaign\Models\Campaign;
use Illuminate\Http\Request;

class CamapaignStoryController
{
    public function edit(Campaign $campaign)
    {
        return view('campaign::content.story', ['campaign' => $campaign]);
    }

    public function update(Request $request, Campaign $campaign, ExtractRemovedImageBlocks $action)
    {
        $removedImageBlocks = $action->execute(
            json_decode($campaign->content, true) ?? [],
            json_decode($request->content, true) ?? []
        );

        $campaign->update([
            'content' => $request->content,
            'description' => strip_tags($request->description),
        ]);

        foreach ($removedImageBlocks as $block) {
            app(DeleteMediaByUrl::class)->execute($campaign, $block['data']['file']['url']);
        }
        flash('Content updated successfully', 'success');

        return redirect()->back();
    }

    public function uploadImage(Request $request, Campaign $campaign)
    {
        $media = $campaign->addMediaFromRequest('image')
            ->withResponsiveImages()
            ->toMediaCollection('content_images');

        return response()->json(['success' => 1, 'file' => [
            'url' => $media->getUrl(),
        ]]);
    }
}
