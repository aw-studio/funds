<?php

namespace Funds\Reward\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardVariant extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'description',
    ];

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->reward->min_amount
        );
    }
}
