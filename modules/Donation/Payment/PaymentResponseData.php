<?php

namespace Funds\Donation\Payment;

class PaymentResponseData
{
    public function __construct(
        public readonly array $data
    ) {}
}
