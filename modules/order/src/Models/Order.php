<?php

namespace Funds\Order\Models;

use Funds\Donation\Models\Donation;
use Funds\Order\Enums\OrderShipmentStatus;
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
        'shipment_status',
        'shipment_adress',
    ];

    protected $attributes = [
        'shipment_status' => OrderShipmentStatus::Pending,
    ];

    public function casts(): array
    {
        return [
            'shipping_address' => 'array',
            'shipment_status' => OrderShipmentStatus::class,
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

    public function markAsShipped()
    {
        $this->shipment_status = OrderShipmentStatus::Shipped;
        $this->save();
    }
}
