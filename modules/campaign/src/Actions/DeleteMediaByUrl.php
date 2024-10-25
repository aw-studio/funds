<?php

namespace Funds\Campaign\Actions;

use Funds\Campaign\Models\Campaign;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DeleteMediaByUrl
{
    public function execute(Campaign $campaign, string $url)
    {
        preg_match('/\/storage\/(\d+)\//', $url, $matches);
        $id = $matches[1] ?? null;

        if (! $id) {
            return;
        }

        $media = Media::where('model_id', $campaign->id)
            ->where('model_type', Campaign::class)
            ->where('id', $id)
            ->first();

        if (! $media) {
            return;
        }

        $media->delete();

    }
}
