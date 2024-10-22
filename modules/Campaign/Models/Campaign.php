<?php

namespace Funds\Campaign\Models;

use Funds\Campaign\Actions\RenderEditorContent;
use Funds\Campaign\Enum\CampaignStatus;
use Funds\Campaign\Theme\CampaginStyles;
use Funds\Donations\Models\Donation;
use Funds\Donations\Models\DonationIntent;
use Funds\Foundation\Support\Amount;
use Funds\Foundation\Support\Casts\AmountCast;
use Funds\Reward\Models\Reward;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        'content',
        'goal',
        'start_date',
        'end_date',
        'status',
        'fees',
        'slug',
        'is_active',
    ];

    protected $attributes = [
        'status' => CampaignStatus::Draft,
    ];

    public function casts()
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            // 'status' => CampaignStatus::enum,
            'goal' => AmountCast::class,
            'settings' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function getRenderedContentAttribute(): ?string
    {
        try {
            return app(RenderEditorContent::class)->execute($this, $this->content);
        } catch (\Exception $e) {
            ray($e->getMessage());

            return '';
        }
    }

    public static function booted()
    {
        static::addGlobalScope('total_donated_scope', function ($query) {
            $query->withSum('donations as total_donated', 'amount');
        });
    }

    public function getStatusAttribute()
    {

        if ($this->is_active && $this->start_date > now()) {
            return CampaignStatus::Planned;
        }

        if ($this->is_active && $this->start_date < now() && $this->end_date > now()) {
            return CampaignStatus::Published;
        }

        if ($this->is_active && $this->end_date < now()) {
            return CampaignStatus::Closed;
        }

        return CampaignStatus::Draft;
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }

    public function topRewards()
    {
        return $this->rewards()
            ->topForCampaign($this);
    }

    public function donationIntents()
    {
        return $this->hasMany(DonationIntent::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    public function appRoute()
    {
        return route('campaigns.show', [
            'campaign' => $this,
        ]);
    }

    public function publicRoute()
    {
        return route('campaigns.public.show', [
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

        $this->addMediaCollection('intro_image')
            ->singleFile();

        $this->addMediaCollection('content_images');

        $this->addMediaCollection('pitch_video')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->performOnCollections('pitch_video');
    }

    public function orderDonationCount()
    {
        return $this->donations()->whereHas('order')->count();
    }

    public function noOrderDonationCount()
    {
        return $this->donations()->whereDoesntHave('order')->count();
    }

    public function styles()
    {
        return new CampaginStyles(
            colors: array_filter($this->settings['colors'] ?? []),
            radii: array_filter($this->settings['radius'] ?? []),
        );
    }

    public function getCssVariables()
    {
        $styles = $this->styles();

        return $styles->toCssVariables();
    }
}
