<?php

namespace Funds\Donations\Models;

use Funds\Campaign\Concerns\BelongsToCampaign;
use Funds\Donations\DTOs\DonationIntentDto;
use Funds\Donations\Events\DonationIntentSucceeded;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
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
            'rewards' => 'array',
            'recurring_donation_data' => 'array',
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

        $this->donation_id = $donation->id;
        $this->setRelation('donation', $donation);

        // this could also just be a DonationCreated event?
        DonationIntentSucceeded::dispatch($this->asDto());
    }

    public function asDto(): DonationIntentDto
    {
        return new DonationIntentDto(
            $this->email,
            $this->amount,
            $this->campaign_id,
            $this->id,
            $this->rewards,
            $this->type
        );
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
