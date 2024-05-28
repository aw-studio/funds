<?php

namespace Funds\Donations\Payment;

class PaymentResponseData
{
    public function __construct(
        public readonly array $data
    ) {
    }
}
