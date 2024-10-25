<?php

namespace Funds\Campaign\Actions;

class GetMediaIdFromUrl
{
    public function execute(string $url)
    {
        preg_match('/\/storage\/(\d+)\//', $url, $matches);
        $id = $matches[1] ?? null;

        return $id;

    }
}
