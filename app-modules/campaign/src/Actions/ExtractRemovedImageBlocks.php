<?php

namespace Funds\Campaign\Actions;

class ExtractRemovedImageBlocks
{
    public function execute(array $oldContent, array $newContent)
    {
        $imageIdsInSecondJson = [];
        foreach ($newContent['blocks'] as $block) {
            if ($block['type'] === 'image') {
                $imageIdsInSecondJson[] = $block['id'];
            }
        }

        // Filter out image blocks from the first JSON object that are not in the second JSON
        $filteredImages = array_filter($oldContent['blocks'], function ($block) use ($imageIdsInSecondJson) {
            return $block['type'] === 'image' && ! in_array($block['id'], $imageIdsInSecondJson);
        });

        return $filteredImages;
    }
}
