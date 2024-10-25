<?php

namespace Funds\Campaign\Theme;

class ThemeOption
{
    public function __construct(
        public string $key,
        public string $label,
        public string $description,
    ) {}
}
