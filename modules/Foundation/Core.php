<?php

namespace Funds\Foundation;

use Funds\Donations\Enums\DonationType;
use Funds\Donations\Services\DonationIntentService;
use Funds\Donations\Services\DonationService;
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

    public function resolveIntentHandler(DonationType $donationType): DonationIntentServiceInterface
    {

        if ($donationType === DonationType::Recurring && app()->bound('funds.donationIntentHandler.recurring')) {
            return app('funds.donationIntentHandler.recurring');
        }

        return new DonationIntentService;

    }

    public function donationService(DonationType $donationType): DonationServiceInterface
    {

        if ($donationType === DonationType::Recurring && app()->bound('funds.donationHandler.recurring')) {
            return app('funds.donationHandler.recurring');
        }

        return new DonationService;

    }
}
