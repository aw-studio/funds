<?php

namespace Funds\Campaign\Actions;

use Funds\Campaign\Models\Campaign;

class ResolvePublicCampaignIndex
{
    public function __invoke()
    {
        if (config('funds.single_campaign_mode')) {
            return $this->handleSingleCampaignMode();
        }

        if (config('funds.public_campaign_overview')) {
            return view('welcome');
        }

        return redirect()->route('dashboard');
    }

    protected function handleSingleCampaignMode()
    {
        $currentCampaign = Campaign::currentCampaign()->first();

        if (! $currentCampaign) {
            return $this->handleNoCurrentCampaign();
        }

        return app(ShowPublicCampaign::class)($currentCampaign);
    }

    protected function handleNoCurrentCampaign()
    {
        if (config('funds.public_campaign_overview')) {
            return view('welcome');
        }

        abort(403);
    }
}
