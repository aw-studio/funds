<?php
use Funds\Campaign\Enum\CampaignVisibility;
$colors = match ($campaign->visibility) {
    CampaignVisibility::Draft => 'bg-gray-200 text-gray-600',
    CampaignVisibility::Published => 'bg-blue-200 text-blue-600',
    CampaignVisibility::Archived => 'bg-gray-200 text-gray-600',
};
?>
<span @class(['px-2 py-1 rounded-md text-xs', $colors])>
    {{ $campaign->visibility->label() }}
</span>
