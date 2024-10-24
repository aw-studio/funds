<?php
use Funds\Campaign\Enum\CampaignStage;
$colors = match ($campaign->stage) {
    CampaignStage::Unplanned => 'bg-gray-200 text-gray-600',
    CampaignStage::Upcoming => 'bg-orange-200 text-orange-600',
    CampaignStage::Running => 'bg-blue-200 text-blue-600',
    CampaignStage::Completed => 'bg-purple-200 text-purple-600',
};
?>
<span @class(['px-2 py-1 rounded-md text-xs', $colors])>
    {{ $campaign->stage->label() }}
</span>
