<?php

namespace Funds\Donation\Models;

use Funds\Campaign\Concerns\BelongsToCampaign;
use Funds\Donation\Builder\DonationBuilder;
use Funds\Donation\Enums\DonationType;
use Funds\Foundation\Support\Amount;
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

    public function newCollection(array $models = [])
    {
        return new DonationCollection($models);
    }

    public function newEloquentBuilder($query): DonationBuilder
    {
        return new DonationBuilder($query);
    }

    public function casts(): array
    {
        return [
            'type' => DonationType::class,
            'receipt_address' => 'array',
        ];
    }

    public function getAmountAttribute($value)
    {
        return new Amount($value);
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
        if (($this->reward) !== null) {
            return __('Reward donation');
        }

        return __('Simple donation');
    }

    public function paidFeeAmount(): Amount
    {
        $feePercentage = $this->campaign->fees / 100;
        $amountWithoutFees = $this->amount->get() / (1 + $feePercentage);
        $feeAmount = $this->amount->get() - $amountWithoutFees;

        return new Amount($feeAmount);
    }

    public function paidFees(): bool
    {
        return $this->donationIntent?->pays_fees ?? false;
    }
}
