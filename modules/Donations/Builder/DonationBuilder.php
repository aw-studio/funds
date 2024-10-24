<?php

namespace Funds\Donations\Builder;

use Funds\Donations\Enums\DonationType;
use Funds\Reward\Models\Reward;
use Illuminate\Database\Eloquent\Builder;

class DonationBuilder extends Builder
{
    public function onetime()
    {
        return $this->where('type', DonationType::OneTime);
    }

    public function recurring()
    {
        return $this->where('type', DonationType::Recurring);
    }

    public function search($search)
    {
        return $this->whereHas('donor', function ($donorQuery) use ($search) {
            $donorQuery->search($search);
        })->orWhereHas('order', function ($orderQuery) use ($search) {
            $orderQuery->search($search);
        });
    }

    public function filterReward(int|string|Reward $reward)
    {
        if ($reward instanceof Reward) {
            $reward = $reward->id;
        }

        return $this->whereHas('order', function ($orderQuery) use ($reward) {
            $orderQuery->where('reward_id', $reward);
        });
    }
}
