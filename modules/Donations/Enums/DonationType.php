<?php

namespace Funds\Donations\Enums;

enum DonationType: string
{
    case OneTime = 'one_time';
    case Recurring = 'recurring';
}
