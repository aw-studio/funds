<?php

namespace Funds\Donations\Models;

use Funds\Campaign\Concerns\BelongsToCampaign;
use Funds\Core\Support\Amount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $email
 * @property \Funds\Campaign\Models\Campaign $campaign
 * @property Amount $amount
 */
class Donation extends Model
{
    use BelongsToCampaign;
    use HasFactory;

    public $fillable = [
        'amount',
        'receipt_address',
    ];

    public function getAmountAttribute($value)
    {
        return new Amount($value);
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public static function createFromIntent(DonationIntent $intent): self
    {
        $donor = Donor::firstOrCreate(['email' => $intent->email]);

        $donation = new self();
        $donation->donor_id = $donor->id;
        $donation->amount = $intent->amount;
        $donation->campaign = $intent->campaign;
        $donation->save();

        return $donation;
    }
}
