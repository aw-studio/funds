<?php

namespace Funds\Campaign\Models;

use Funds\Campaign\Enum\CampaignStatus;
use Funds\Core\Support\Casts\AmountCast;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\DonationIntent;
use Funds\Reward\Models\Reward;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'description',
        'goal',
        'start_date',
        'end_date',
        'status',
    ];

    protected $attributes = [
        'status' => CampaignStatus::Draft,
    ];

    public function casts()
    {
        return [
            'status' => CampaignStatus::class,
            'goal' => AmountCast::class,
        ];
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }

    public function donationIntents()
    {
        return $this->hasMany(DonationIntent::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function appRoute()
    {
        return route('campaigns.show', [
            'campaign' => $this,
        ]);

    }
}
