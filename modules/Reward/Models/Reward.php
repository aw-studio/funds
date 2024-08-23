<?php

namespace Funds\Reward\Models;

use Funds\Campaign\Concerns\BelongsToCampaign;
use Funds\Core\Support\Casts\AmountCast;
use Funds\Reward\Models\Scopes\CampaignScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property Campaign $campaign
 */
#[ScopedBy([CampaignScope::class])]
class Reward extends Model implements HasMedia
{
    use BelongsToCampaign;
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'min_amount',
    ];

    public function casts(): array
    {
        return [
            'min_amount' => AmountCast::class,
        ];
    }

    public function variants()
    {
        return $this->hasMany(RewardVariant::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }
}
