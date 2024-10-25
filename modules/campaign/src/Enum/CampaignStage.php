<?php

namespace Funds\Campaign\Enum;

enum CampaignStage: string
{
    case Unplanned = 'unplanned';
    case Upcoming = 'Upcoming';
    case Running = 'running';
    case Ended = 'ended';
    case Finished = 'finished';

    public function label(): string
    {
        return match ($this) {
            self::Unplanned => __('Unplanned'),
            self::Upcoming => __('Upcoming'),
            self::Running => __('Running'),
            self::Ended => __('Ended'),
            self::Finished => __('Finished'),
        };
    }
}
