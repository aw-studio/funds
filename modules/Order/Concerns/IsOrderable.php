<?php

namespace Funds\Order\Concerns;

use Funds\Order\Models\Order;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait IsOrderable
{
    public function orders(): MorphMany
    {
        return $this->morphMany(Order::class, 'orderable');
    }
}
