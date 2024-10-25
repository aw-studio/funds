<?php

namespace Funds\Foundation\Contracts;

use Funds\Campaign\Models\Campaign;
use Funds\Donation\Models\DonationIntent;
use Funds\Donation\Payment\PaymentResponseData;
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
