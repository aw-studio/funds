<?php

namespace Funds\Donations\DTOs;

readonly class DonationIntentDto
{
    public function __construct(
        public ?string $id,
        public string $name,
        public string $email,
        public int $amount,
        public string $type,
        public bool $paysFees,
        public int $campaignId,
        public ?string $donationId,
        public ?array $orderDetails = null
    ) {}
}
