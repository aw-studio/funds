<?php

namespace Funds\Campaign\Enum;

enum CampaignStatus: string
{
    case Draft = 'draft';
    case Planned = 'planned';
    case Published = 'published';
    case Closed = 'closed';

    public function is(string $status): bool
    {
        return $this->value === $status;
    }

    public function isPublic(): bool
    {
        return $this->is(self::Published->value);
    }

    public function label(): string
    {
        return match ($this) {
            self::Draft => __('Draft'),
            self::Planned => __('Planned'),
            self::Published => __('Published'),
            self::Closed => __('Closed'),
        };
    }
}
