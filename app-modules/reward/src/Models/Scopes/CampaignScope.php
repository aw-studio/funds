<?php

namespace Funds\Reward\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CampaignScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->user()?->current_campaign_id === null) {
            return;
        }

        $builder->where('campaign_id', auth()->user()->current_campaign_id);
        //
    }
}
