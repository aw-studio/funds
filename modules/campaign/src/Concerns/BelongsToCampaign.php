<?php

namespace Funds\Campaign\Concerns;

use Funds\Campaign\Models\Campaign;

trait BelongsToCampaign
{
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function setCampaignAttribute(Campaign $campaign): void
    {
        $this->campaign_id = $campaign->id;
        $this->setRelation('campaign', $campaign);
    }

    public function scopeCampaign($query, Campaign $campaign)
    {
        return $query->where('campaign_id', $campaign->id);
    }
}
