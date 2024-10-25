<?php

namespace Funds\Campaign\Actions;

use EditorJS\EditorJS;
use Funds\Campaign\Models\Campaign;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class RenderEditorContent
{
    public function execute(Campaign $campaign, $rawData): HtmlString
    {

        $configJson = json_encode(config('laravel_editorjs.config') ?: []);

        $editor = new EditorJS($rawData, $configJson);

        $renderedBlocks = [];

        foreach ($editor->getBlocks() as $block) {

            $viewName = 'laravel_editorjs::blocks.'.Str::snake($block['type'], '-');

            // CUSTOM PART
            if ($block['type'] === 'image') {
                $id = app(GetMediaIdFromUrl::class)->execute($block['data']['file']['url']);
                $media = $campaign->media->where('id', $id)->first();
                $block['data']['media'] = $media;
            }

            if (! View::exists($viewName)) {
                $viewName = 'laravel_editorjs::blocks.not-found';
            }

            $renderedBlocks[] = View::make($viewName, [
                'type' => $block['type'],
                'data' => $block['data'],
            ])->render();
        }

        return new HtmlString(implode($renderedBlocks));
    }
}
