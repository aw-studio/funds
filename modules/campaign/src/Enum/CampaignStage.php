<?php

namespace Funds\Campaign\Enum;

enum CampaignStage: string
{
    case Unplanned = 'unplanned';
    case Upcoming = 'upcoming';
    case Running = 'running';
    case Ended = 'ended';

    public function label(): string
    {
        return match ($this) {
            self::Unplanned => __('Unplanned'),
            self::Upcoming => __('Upcoming'),
            self::Running => __('Running'),
            self::Ended => __('Ended'),
        };
    }
}
