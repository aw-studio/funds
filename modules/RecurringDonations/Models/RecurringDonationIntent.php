<?php

namespace Funds\RecurringDonations\Models;

use Funds\Donations\Models\DonationIntent;

/**
 * @property array $recurring_donation_data
 */
class RecurringDonationIntent extends DonationIntent
{
    public $table = 'donation_intents';

    public $fillable = [
        'recurring_donation_data',
    ];

    public $casts = [
        'recurring_donation_data' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (RecurringDonationIntent $intent) {
            $intent->type = 'recurring';
        });
    }

    public static function fromDonationIntent(DonationIntent $intent)
    {

    }
}
