<?php

namespace Funds\Donations\Models;

use Funds\Campaign\Concerns\BelongsToCampaign;
use Funds\Donations\DTOs\DonationIntentDto;
use Funds\Donations\Events\DonationIntentSucceeded;
use Funds\Reward\Models\Reward;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $type
 * @property \Funds\Campaign\Models\Campaign $campaign
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
        'email',
        'status',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function casts(): array
    {
        return [
            'recurring_donation_data' => 'array',
            'order_details' => 'array',
        ];
    }

    public function succeed(): void
    {
        $this->status = 'succeeded';
        $this->save();

        if (Donation::where('intent_id', $this->id)->exists()) {
            return;
        }

        if ($this->donation !== null) {
            // This is a rety, is that possible?
        }

        $donation = Donation::createFromIntent($this);

        $this->donation = $donation;

        // this could also just be a DonationCreated event?
        DonationIntentSucceeded::dispatch($this->asDto());
    }

    public function fail()
    {
        if ($this->status !== 'pending') {
            throw new \Exception('Cannot fail intent that is not pending');
        }

        if ($this->donation !== null) {
            throw new \Exception('Donation already created, cannot fail intent');
        }

        $this->status = 'failed';
        $this->save();
    }

    public function asDto(): DonationIntentDto
    {
        return new DonationIntentDto(
            email: $this->email,
            amount: $this->amount,
            campaignId: $this->campaign->id,
            donationId: $this->donation?->id,
            type: $this->type,
            orderDetails: $this->order_details,
        );
    }

    public function donation()
    {
        return $this->hasOne(Donation::class, 'intent_id');
    }

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
