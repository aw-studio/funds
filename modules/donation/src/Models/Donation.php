<?php

namespace Funds\Donation\Models;

use Barryvdh\DomPDF\Facade\Pdf;
use Funds\Campaign\Traits\BelongsToCampaign;
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
        return __('One-time donation');
    }

    public function receiptPdf(): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('donation::pdf.donation-receipt', [
            'donation' => $this,
        ]);
    }

    public function paidFeeAmount(): Amount
    {
        if (! $this->paidFees()) {
            return new Amount(0);
        }
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
