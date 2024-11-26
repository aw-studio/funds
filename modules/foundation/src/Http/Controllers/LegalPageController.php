<?php

namespace Funds\Foundation\Http\Controllers;

use Funds\Foundation\SettingsService;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class LegalPageController
{
    public function __construct(protected SettingsService $settingsService) {}

    public function __invoke($page)
    {
        $content = $this->settingsService->get($page);

        if (! $content) {
            abort(404);
        }

        if (filter_var($content, FILTER_VALIDATE_URL)) {
            return redirect($content);
        }

        $content = Str::of($content)->markdown();
        $content = new HtmlString($content);

        return view('funds::public.pages.legalpage', ['content' => $content]);
    }
}
