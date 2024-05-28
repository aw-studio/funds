<?php

namespace Funds\Reward\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardVariant extends Model
{
    use HasFactory;

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
