<?php

namespace Funds\Campaign\Views\ViewComponents;

use Funds\Campaign\Models\Campaign;
use Illuminate\View\Component;
use Illuminate\View\View;

class CampaignLayout extends Component
{
    // public $campaign;

    public function __construct(
    ) {
        // this should be resolved via the current_campaign
        // $this->campaign = Campaign::find(session('campaign_id'));
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {

        return view('campaigns::layouts.campaign-layout');
    }
}
