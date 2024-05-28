<?php

namespace Funds\Core\Support;

use NumberFormatter;

class Amount implements \Stringable
{
    public function __construct(
        public int $cents
    ) {
    }

    public function format(): string
    {
        return NumberFormatter::create('de_DE', NumberFormatter::CURRENCY)->format($this->cents / 100);
    }

    public function get(): int
    {
        return $this->cents;
    }

    public function __toString(): string
    {
        return $this->format();
    }
}
