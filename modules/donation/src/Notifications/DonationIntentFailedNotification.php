<?php

namespace Funds\Donation\Notifications;

use Funds\Campaign\Models\Campaign;
use Funds\Donation\DTOs\DonationIntentDto;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationIntentFailedNotification extends Notification
{
    use Queueable;

    public Campaign $campaign;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public DonationIntentDto $donationIntentDto
    ) {
        $this->campaign = Campaign::find($this->donationIntentDto->campaignId);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Your Donation Failed'))
            ->greeting(__('Hi,'))
            ->line(__('Unfortunately, something went wrong with your donation to :campaignName', ['campaignName' => $this->campaign->name]))
            ->line(__('We would be very happy if you try it again. Or contact us for further assictance.'));
    }
}
