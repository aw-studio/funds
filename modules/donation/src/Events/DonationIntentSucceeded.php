<?php

namespace Funds\Donation\Events;

use Funds\Donation\DTOs\DonationIntentDto;
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
