<?php

namespace Funds\Campaign\Models;

use Funds\Campaign\Actions\RenderEditorContent;
use Funds\Campaign\Enum\CampaignStage;
use Funds\Campaign\Enum\CampaignVisibility;
use Funds\Campaign\Theme\CampaginStyles;
use Funds\Donation\Models\Donation;
use Funds\Donation\Models\DonationIntent;
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
        'meta_description',
        'social_share_text',
        'youtube_id',
        'content',
        'goal',
        'start_date',
        'end_date',
        'status',
        'fees',
        'slug',
        'settings->show_progress',
        'published_at',
    ];

    public function casts()
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'goal' => AmountCast::class,
            'settings' => 'array',
        ];
    }

    public function getRenderedContentAttribute(): ?string
    {
        try {
            return app(RenderEditorContent::class)->execute($this, $this->content);
        } catch (\Exception $e) {
            return '';
        }
    }

    public static function booted()
    {
        static::addGlobalScope('total_donated_scope', function ($query) {
            $query->withTotalDonated();
        });
    }

    public function scopeWithTotalDonated($query)
    {
        return $query->withSum('donations as total_donated', 'amount');
    }

    public function getStageAttribute()
    {
        return match (true) {
            $this->start_date == null => CampaignStage::Unplanned,
            $this->start_date > now() => CampaignStage::Upcoming,
            $this->start_date <= now() && $this->end_date >= now() => CampaignStage::Running,
            $this->end_date < now() => CampaignStage::Ended,
        };

    }

    public function getVisibilityAttribute()
    {
        if ($this->published_at == null) {
            return CampaignVisibility::Draft;
        }

        return CampaignVisibility::Published;
    }

    public function isPublic()
    {
        return $this->visibility == CampaignVisibility::Published;
    }

    public function isRunning()
    {
        return $this->stage == CampaignStage::Running;
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

    public function getUrl()
    {
        return config('funds.single_campaign_mode') ?
            url('/') :
            route('campaigns.public.show', ['campaign' => $this]);
    }

    public function publicRoute()
    {
        return route('campaigns.public.show', [
            'campaign' => $this,
        ]);
    }

    public function scopeRunning($query)
    {
        return $query->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '!=', null);
    }

    public function scopeCurrentCampaign($queryBuilder)
    {
        return $queryBuilder
            ->running()
            ->published();
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
        $progress = max(0, min(100, (int) $progress));

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

        // OG Image
        $this->addMediaCollection('og_image')
            ->singleFile();
        // Twitter Image
        $this->addMediaCollection('twitter_image')
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

    public function isPublished()
    {
        return $this->published_at !== null;
    }

    public function unPublish()
    {
        $this->published_at = null;
        $this->save();
    }

    public function publish()
    {
        $this->published_at = now();
        $this->save();
    }

    public function showDonationProgress()
    {
        return $this->settings['show_progress'] ?? true;
    }
}
