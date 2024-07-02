<?php

namespace Funds\Donations\DTOs;

readonly class DonationIntentDto
{
    public function __construct(
        public string $email,
        public int $amount,
        public int $campaignId,
        public ?string $donationId,
        public string $type,
        public ?array $orderDetails = null
    ) {
    }
}
