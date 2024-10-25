<?php

namespace Funds\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void enable(array $modules)
 * @method static bool has(string $module)
 * @method static \Funds\Foundation\PaymentGatewayResolver payment()
 * @method static \Funds\Foundation\Navigation navigation()
 * @method static \Funds\Foundation\Contracts\DonationIntentServiceInterface intentHandler()
 * @method static \Funds\Foundation\Contracts\DonationServiceInterface donationService()
 *
 * @see \Funds\Foundation\Core
 */
class Funds extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'funds.core';
    }
}
