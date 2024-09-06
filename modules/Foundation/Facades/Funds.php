<?php

namespace Funds\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void enable(array $modules)
 * @method static bool has(string $module)
 * @method static \Funds\Foundation\PaymentGatewayResolver payment()
 * @method static \Funds\Foundation\Navigation navigation()
 * @method static \Funds\Foundation\Contracts\DonationIntentServiceInterface resolveIntentHandler(\Funds\Donations\Enums\DonationType $type)
 * @method static \Funds\Foundation\Contracts\DonationServiceInterface donationService(\Funds\Donations\Enums\DonationType $type)
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
