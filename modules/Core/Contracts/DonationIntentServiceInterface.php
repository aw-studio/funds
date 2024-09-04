<?php

namespace Funds\Core\Contracts;

use Funds\Campaign\Models\Campaign;
use Funds\Donations\Models\DonationIntent;
use Funds\Donations\Payment\PaymentResponseData;
use Funds\Reward\Models\Reward;

interface DonationIntentServiceInterface
{
    public function createDonationIntent(
        array $data,
        Campaign $campaign,
        ?Reward $reward
    ): DonationIntent;

    public function processIntent(
        DonationIntent $intent,
        PaymentGatewayInterface $paymentGateway,
        array $validatedData
    ): PaymentResponseData|bool;
}
