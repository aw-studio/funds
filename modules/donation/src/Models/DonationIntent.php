<?php

namespace Funds\Donation\Models;

use Funds\Campaign\Traits\BelongsToCampaign;
use Funds\Donation\DTOs\DonationIntentDto;
use Funds\Donation\Enums\DonationIntentStatus;
use Funds\Donation\Events\DonationIntentSucceeded;
use Funds\Foundation\Facades\Funds;
use Funds\Foundation\Support\Amount;
use Funds\Reward\Models\Reward;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $type
 * @property \Funds\Campaign\Models\Campaign $campaign
 * @property int $amount
 *
 * @method succeed()
 */
class DonationIntent extends Model
{
    use BelongsToCampaign;
    use HasFactory;
    use HasUlids;

    public $fillable = [
        'amount',
        'name',
        'email',
        'status',
    ];

    protected $attributes = [
        'status' => DonationIntentStatus::Pending,
    ];

    public function casts(): array
    {
        return [
            'status' => DonationIntentStatus::class,
            'recurring_donation_data' => 'array',
            'order_details' => 'array',
            'receipt_address' => 'array',
        ];
    }

    public function fetchPaymentIntentFromStripe()
    {
        // Fetch payment intent from stripe
        $stripe = new \Stripe\StripeClient([
            'api_key' => config('services.stripe.secret'),
        ]);

        return $stripe->paymentIntents->retrieve($this->payment_intent);
    }

    public function fetchPaymentMethodFromStripe()
    {
        $stripe = new \Stripe\StripeClient([
            'api_key' => config('services.stripe.secret'),
        ]);

        return $stripe->paymentMethods->retrieve(
            $this->fetchPaymentIntentFromStripe()->payment_method
        );
    }

    public function getAmount(): Amount
    {
        return new Amount($this->amount);
    }

    public function succeed(): void
    {
        $this->status = DonationIntentStatus::Succeeded;
        $this->save();

        if (Donation::where('intent_id', $this->id)->exists()) {
            return;
        }

        if ($this->donation !== null) {
            // This is a rety, is that possible?
        }

        $this->donation = $this->convertToDonation();

        // this could also just be a DonationCreated event?
        DonationIntentSucceeded::dispatch($this->asDto());
    }

    public function convertToDonation(): Donation
    {
        return Funds::donationService()->createDonationFromIntent($this->asDto());
    }

    public function fail(): void
    {
        if ($this->status !== DonationIntentStatus::Pending) {
            throw new \Exception('Cannot fail intent that is not pending');
        }

        if ($this->donation !== null) {
            throw new \Exception('Donation already created, cannot fail intent');
        }

        $this->status = DonationIntentStatus::Failed;
        $this->save();
    }

    public function asDto(): DonationIntentDto
    {
        return new DonationIntentDto(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            amount: $this->amount,
            type: $this->type,
            paysFees: $this->pays_fees,
            campaignId: $this->campaign->id,
            receiptAddress: $this->receipt_address,
            donationId: $this->donation?->id,
            orderDetails: $this->order_details,
        );
    }

    public function donation()
    {
        return $this->hasOne(Donation::class, 'intent_id');
    }

    /**
     * TODO: is this relation really required?
     */
    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    public function setDonationAttribute(Donation $donation): void
    {
        $this->donation_id = $donation->id;
        $this->setRelation('donation', $donation);
    }
}
