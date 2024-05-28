<?php

namespace Funds\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void enable(array $modules)
 * @method static bool has(string $module)
 * @method static \Funds\Core\PaymentGatewayResolver payment()
 *
 * @see \Funds\Core\Core
 */
class Funds extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'funds.core';
    }
}
