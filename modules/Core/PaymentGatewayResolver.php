<?php

namespace Funds\Core;

use Funds\Core\Contracts\PaymentGatewayInterface;
use Funds\Donations\Enums\DonationType;

class PaymentGatewayResolver
{
    protected array $gateways = [];

    public function register(string $gateway): void
    {
        if (! class_exists($gateway)) {
            throw new \Exception('Provider '.$gateway.' not found');
        }

        if (! in_array(PaymentGatewayInterface::class, class_implements($gateway))) {
            throw new \Exception('Provider '.$gateway.' does not implement PaymentGatewayInterface');
        }

        $this->gateways[] = $gateway;
    }

    public function resolve(DonationType $type): PaymentGatewayInterface
    {
        $gateways = array_filter($this->gateways, fn (string $gateway) => $gateway::canBeUsedFor($type));

        if ($gateways == []) {
            throw new \Exception('No payment gateway found for donation type: '.$type);
        }

        $gateway = reset($gateways);

        if ($gateway === false) {
            throw new \Exception('No provider found for donation type '.$type);
        }

        return new $gateway;
    }
}
