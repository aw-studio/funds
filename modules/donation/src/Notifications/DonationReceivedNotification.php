<?php

namespace Funds\Donation\Notifications;

use Funds\Donation\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class DonationReceivedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Donation $donation
    ) {
        //
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
        $message = (new MailMessage)
            ->subject(__('We received your donation').'!')
            ->line(new HtmlString(__('Your donation of :amount has been received.', [
                'amount' => '<strong>'.$this->donation->amount.'</strong>',
            ])))
            ->line(__('Thank you for supporting our cause').'.');

        if ($this->donation->order) {
            $line = __('The order of your reward :rewardName is being processed and will be shipped shortly.', [
                'rewardName' => '<strong>'.$this->donation->order->reward->name.'</strong>',
            ]);
            $line .= ' '.__('We will notify you with the tracking information once your order has been shipped.');
            $message->line(new HtmlString($line));
        }

        if ($this->donation->receipt_address !== null) {
            $message->line(__('Your donation receipt will be attached to this email.'));

            $pdf = $this->donation->receiptPdf();

            $message->attachData(
                $pdf->output(),
                'donation-receipt-'.$this->donation->id.'.pdf',
                ['mime' => 'application/pdf']
            );

        }

        return $message;

    }
}
