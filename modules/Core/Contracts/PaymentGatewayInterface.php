<?php

namespace Funds\Core\Contracts;

use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Payment\PaymentResponseData;

interface PaymentGatewayInterface
{
    public function process(
        DonationIntent $donationIntent,
        array $validatedData
    ): PaymentResponseData|bool;

    public static function canBeUsedFor(string $type): bool;

    public static function rules(): array;
}
