<?php

namespace Funds\Foundation\Contracts;

use Funds\Donation\Enums\DonationType;
use Funds\Donation\Models\DonationIntent;
use Funds\Donation\Payment\PaymentResponseData;

interface PaymentGatewayInterface
{
    public function process(
        DonationIntent $donationIntent,
        array $validatedData
    ): PaymentResponseData|bool;

    public static function canBeUsedFor(DonationType $type): bool;

    public static function rules(): array;
}
