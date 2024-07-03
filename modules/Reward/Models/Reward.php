<?php

namespace Funds\Reward\Models;

use Funds\Campaign\Concerns\BelongsToCampaign;
use Funds\Core\Support\Casts\AmountCast;
use Funds\Reward\Models\Scopes\CampaignScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Campaign $campaign
 */
#[ScopedBy([CampaignScope::class])]
class Reward extends Model
{
    use BelongsToCampaign;
    use HasFactory;

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
}
