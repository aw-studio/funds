<?php

namespace Funds\Donations\Events;

use Funds\Donations\DTOs\DonationIntentDto;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DonationIntentSucceeded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public DonationIntentDto $donationIntentData,
    ) {
        //
    }
}
