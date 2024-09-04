<?php

namespace Funds\Core;

use Funds\Donations\Models\Donation;

/**
 * This class is responsible for resolving additional data for a donation based on its type.
 */
class DonationIntentHandlerResolver
{
    protected $typeResolvers = [];

    public function register(string $type, $resolver)
    {
        $this->typeResolvers[$type] = $resolver;
    }

    /**
     * Resolves additional data for a donation.
     */
    public function resolve(Donation $donation)
    {
        if (! isset($this->typeResolvers[$donation->type])) {
            return $donation;
        }

        $resolver = $this->typeResolvers[$donation->type];

        return (new $resolver)->resolve($donation);

    }
}
