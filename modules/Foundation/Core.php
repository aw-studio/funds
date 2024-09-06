<?php

namespace Funds\Foundation;

use Funds\Foundation\Contracts\DonationIntentServiceInterface;
use Funds\Foundation\Contracts\DonationServiceInterface;

class Core
{
    protected $donationTypes = [
        'one_time' => 'One Time',
    ];

    public function payment(): PaymentGatewayResolver
    {
        return app('funds.payment');
    }

    public function donationTypes()
    {
        return $this->donationTypes;
    }

    public function addDonationType(string $key, string $value): void
    {
        $this->donationTypes[$key] = $value;
    }

    public function hasDonationType(string $key): bool
    {
        return isset($this->donationTypes[$key]);
    }

    public function navigation(): Navigation
    {
        return app('funds.navigation');
    }

    public function intentHandler(): DonationIntentServiceInterface
    {
        return app(DonationIntentServiceInterface::class);
    }

    public function donationService(): DonationServiceInterface
    {
        return app(DonationServiceInterface::class);
    }
}
