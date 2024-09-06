<?php

namespace Funds\Campaign\Models;

use Funds\Campaign\Enum\CampaignStatus;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\DonationIntent;
use Funds\Foundation\Support\Amount;
use Funds\Foundation\Support\Casts\AmountCast;
use Funds\Reward\Models\Reward;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int total_donated
 *
 * @method \Funds\Foundation\Support\Amount totalAmountDonated()
 */
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
        'fees',
        'slug',
    ];

    protected $attributes = [
        'status' => CampaignStatus::Draft,
    ];

    public function casts()
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'status' => CampaignStatus::class,
            'goal' => AmountCast::class,
            'settings' => 'array',
        ];
    }

    public static function booted()
    {
        static::addGlobalScope('total_donated_scope', function ($query) {
            $query->withSum('donations as total_donated', 'amount');
        });
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

    public function publicRoute()
    {
        return route('public.campaigns.show', [
            'campaign' => $this,
        ]);
    }

    public function totalAmountDonated()
    {
        return new Amount($this->total_donated ?? 0);
    }

    public function progress()
    {
        $totalAmountDonated = $this->totalAmountDonated()->get();
        $goal = $this->goal->get();

        $progress = ($totalAmountDonated / $goal) * 100;
        $progress = max(1, min(100, (int) $progress));

        return $progress;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header_image')
            ->singleFile();
    }

    public function orderDonationCount()
    {
        return $this->donations()->whereHas('order')->count();
    }

    public function noOrderDonationCount()
    {
        return $this->donations()->whereDoesntHave('order')->count();
    }
}
