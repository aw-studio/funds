<?php

namespace Funds\Core;

use Funds\Donations\Enums\DonationType;
use Funds\Donations\Models\Donation;

/**
 * This class is responsible for resolving additional data for a donation based on its type.
 */
class DonationResolver
{
    protected $typeResolvers = [];

    public function register(DonationType $type, $resolver)
    {
        $this->typeResolvers[$type->value] = $resolver;
    }

    /**
     * Resolves additional data for a donation.
     */
    public function resolve(Donation $donation)
    {
        // TODO: This is a temporary fix for the type being a string instead of an enum.
        if (is_string($donation->type)) {
            $donation->type = DonationType::tryFrom($donation->type);
        }

        if (! isset($this->typeResolvers[$donation->type->value])) {
            return $donation;
        }

        $resolver = $this->typeResolvers[$donation->type->value];

        return (new $resolver)->resolve($donation);
    }
}
