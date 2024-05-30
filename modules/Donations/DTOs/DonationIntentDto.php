<?php

namespace Funds\Donations\DTOs;

readonly class DonationIntentDto
{
    public function __construct(
        public string $email,
        public int $amount,
        public int $campaignId,
        public ?string $donationId = null,
        public ?array $rewards = [],
        public string $type = 'donation',
    ) {
    }
}
