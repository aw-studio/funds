<?php

namespace Funds\Donations\Models;

use Funds\Campaign\Concerns\BelongsToCampaign;
use Funds\Core\Support\Amount;
use Funds\Order\Models\Order;
use Funds\Reward\Models\Reward;
use Funds\Reward\Models\RewardVariant;
use Funds\Reward\Models\Scopes\CampaignScope;
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

    public static function createFromIntent(DonationIntent $intent): self
    {
        $donor = Donor::firstOrCreate(
            [
                'email' => $intent->email,
            ],
            [
                'first_name' => $intent->name,
            ]
        );

        $donation = new self();
        $donation->donor_id = $donor->id;
        $donation->amount = $intent->amount;
        $donation->campaign = $intent->campaign;
        $donation->intent_id = $intent->id;
        if ($intent->recurring_donation_data !== null) {
            $donation->type = 'recurring';
        }
        $donation->save();

        return $donation;
    }

    public function donationIntent()
    {
        return $this->belongsTo(DonationIntent::class, 'intent_id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function reward()
    {
        return $this->hasOneThrough(
            Reward::class,
            Order::class,
            'donation_id',
            'id',
            'id',
            'reward_id'
        )->withoutGlobalScope(CampaignScope::class);
    }

    public function rewardVariant()
    {
        return $this->hasOneThrough(
            RewardVariant::class,
            Order::class,
            'donation_id',
            'id',
            'id',
            'reward_variant_id'
        )->withoutGlobalScope(CampaignScope::class);
    }

    public function label(): string
    {
        if ($this->type === 'recurring') {
            return __('Recurring donation');
        }

        if (($this->reward) !== null) {
            return __('Reward donation');
        }

        return __('Donation');
    }
}
