<?php

namespace Funds\Core;

class Core
{
    protected $features = [];

    protected $donationTypes = [
        'onetime' => 'One Time',
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

    public function navigation(): Navigation
    {
        return app('funds.navigation');
    }

    public function donationResolver()
    {
        return app('funds.donationResolver');
    }
}
