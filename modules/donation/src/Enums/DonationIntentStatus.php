<?php

namespace Funds\Donation\Enums;

enum DonationIntentStatus: string
{
    case Pending = 'pending';
    case Succeeded = 'succeeded';
    case Failed = 'failed';
}
