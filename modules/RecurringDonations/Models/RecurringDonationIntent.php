<?php

namespace Funds\RecurringDonations\Models;

use Funds\Donations\Models\DonationIntent;

/**
 * @property array $recurring_donation_data
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RecurringDonationIntent unconfirmed()
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

    public static function booted()
    {
        static::addGlobalScope('recurring', function ($query) {
            $query->where('type', 'recurring');
        });
    }

    public function scopeUnconfirmed($query)
    {
        return $query->where('status', 'pending');
    }

    public function confirm()
    {
        $this->succeed();
    }
}
