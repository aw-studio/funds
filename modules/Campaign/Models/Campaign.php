<?php

namespace Funds\Campaign\Models;

use Funds\Campaign\Enum\CampaignStatus;
use Funds\Core\Support\Amount;
use Funds\Core\Support\Casts\AmountCast;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\DonationIntent;
use Funds\Reward\Models\Reward;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Campaign extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

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

    // public function attributes

    public function casts()
    {
        return [
            'status' => CampaignStatus::class,
            'goal' => AmountCast::class,
            'settings' => 'array',
        ];
    }

    // protected function settings(): Attribute
    // {
    //     return Attribute::make(
    //         get: function (?string $value) {
    //             return (object) json_decode($value ?? [], true);
    //         },
    //         set: function (array|object $value) {
    //             if (is_object($value)) {
    //                 $value = (array) $value;
    //             }

    //             return json_encode($value);
    //         }
    //     )->shouldCache();
    // }

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

    public function publicRoute()
    {
        return route('public.campaigns.show', [
            'campaign' => $this,
        ]);
    }

    public function totalAmountDonated()
    {
        return new Amount($this->donations->sum('amount.cents'));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header_image')
            ->singleFile();
    }
}
