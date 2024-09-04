<?php

namespace Funds\Core\Contracts;

use Funds\Donations\Enums\DonationType;
use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Payment\PaymentResponseData;

interface PaymentGatewayInterface
{
    public function process(
        DonationIntent $donationIntent,
        array $validatedData
    ): PaymentResponseData|bool;

    public static function canBeUsedFor(DonationType $type): bool;

    public static function rules(): array;
}
