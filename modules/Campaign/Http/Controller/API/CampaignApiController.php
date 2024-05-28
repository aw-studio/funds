<?php

namespace Funds\Campaign\Http\Controller\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CampaignApiController
{
    public function show(Request $request)
    {
        return new JsonResponse([
            'name' => 'Campaign 1',
            'goal' => 1000,
            'description' => 'Campaign 1 description',
            'rewards' => [
                [
                    'name' => 'Reward 1',
                    'description' => 'Reward 1 description',
                    'amount' => 100,
                ],
                [
                    'name' => 'Reward 2',
                    'description' => 'Reward 2 description',
                    'amount' => 200,
                ],
            ],
        ]);
    }
}
