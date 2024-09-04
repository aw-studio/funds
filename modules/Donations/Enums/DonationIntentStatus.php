<?php

namespace Funds\Donations\Enums;

enum DonationIntentStatus: string
{
    case Pending = 'pending';
    case Succeeded = 'succeeded';
    case Failed = 'failed';
}
