<?php

namespace Funds\Core;

use Funds\Campaign\Models\Campaign;

class Core
{
    protected $features = [];

    protected $donationTypes = [
        'onetime' => 'One Time',
    ];

    public function getFeatures(): array
    {
        return $this->features;
    }

    public function enable(array|string $feature): void
    {
        if (is_string($feature)) {
            $feature = [$feature];
        }

        $this->features = array_merge($this->features, $feature);
    }

    public function has(string $feature): bool
    {
        return in_array($feature, $this->features);
    }

    public function payment(): PaymentGatewayResolver
    {
        return app('funds.payment');
    }

    public function currentCampaignId(): Campaign
    {
        return app('funds.campaign');
    }

    public function setCurrentCampaignId(Campaign $campaign): void
    {
        session()->put('campaign_id', $campaign->id);
    }

    public function donationTypes()
    {
        return $this->donationTypes;
    }

    public function addDonationType(string $key, string $value): void
    {
        $this->donationTypes[$key] = $value;
    }
}
