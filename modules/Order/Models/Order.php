<?php

namespace Funds\Order\Models;

use Funds\Donation\Models\Donation;
use Funds\Reward\Models\Reward;
use Funds\Reward\Models\RewardVariant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $campaign_id
 * @property int $donation_id
 * @property int $reward_id
 * @property int $reward_variant_id
 * @property array $shipping_address
 */
class Order extends Model
{
    use HasFactory;

    public $fillable = [
        'status',
        'shipment_adress',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function casts(): array
    {
        return [
            'shipping_address' => 'array',
        ];
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    public function rewardVariant()
    {
        return $this->belongsTo(RewardVariant::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('shipping_address', 'like', "%$search%");
    }
}
