<?php

namespace Funds\Campaign\Models;

use Funds\Campaign\Traits\BelongsToCampaign;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use BelongsToCampaign;
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'order',
    ];
}
