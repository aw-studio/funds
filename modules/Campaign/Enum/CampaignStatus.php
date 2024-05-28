<?php

namespace Funds\Campaign\Enum;

enum CampaignStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Closed = 'closed';
}
