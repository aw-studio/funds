<?php

namespace Funds\Donation\Enums;

enum DonationType: string
{
    case OneTime = 'one_time';
    case Recurring = 'recurring';

    public function label(): string
    {
        return match ($this) {
            self::OneTime => __('One-time'),
            self::Recurring => __('Recurring'),
        };
    }

    public function isRecurring(): bool
    {
        return $this === self::Recurring;
    }

    public function isOneTime(): bool
    {
        return $this === self::OneTime;
    }
}
