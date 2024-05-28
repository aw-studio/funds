<?php

namespace Funds\Order\Models;

use Funds\Donations\Models\Donation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
