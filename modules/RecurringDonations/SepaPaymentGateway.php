<?php

namespace Funds\RecurringDonations;

use Funds\Core\Contracts\PaymentGatewayInterface;
use Funds\Donations\Models\DonationIntent;
use Funds\RecurringDonations\Actions\CreateRecurringDonationIntent;

class SepaPaymentGateway implements PaymentGatewayInterface
{
    public function process(DonationIntent $donationIntent, array $validatedData): bool
    {
        // but in our special case we only want to create a confirmation stepj
        // and then create a donation
        // and later transfer the sepa payment to the external system

        (new CreateRecurringDonationIntent())
            ->handle($donationIntent, $validatedData);

        return true;
    }

    public static function canBeUsedFor(string $type): bool
    {
        return $type === 'recurring';
    }

    public static function rules(): array
    {
        return [
            'iban' => ['required', 'string', 'max:34', 'min:20'],
        ];
    }
}
