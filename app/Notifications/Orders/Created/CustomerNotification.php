<?php

namespace App\Notifications\Orders\Created;

use App\Services\Interfaces\InvoicesServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class CustomerNotification extends Notification
{
    use Queueable;

    protected InvoicesServiceInterface $invoicesService;

    /**
     * Create a new notification instance.
     */
    public function __construct(InvoicesServiceInterface $invoicesService)
    {
        $this->invoicesService = $invoicesService;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail',];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $invoice = $this->invoicesService->generate($notifiable);

        return (new MailMessage)
                    ->greeting("Hello, {$notifiable->name}")
                    ->line('You order created!')
                    ->attach(Storage::disk('public')->path($invoice->filename), [
                        'mime' => 'application/pdf',
                        'as' => $invoice->name,
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toTelegram(object $notifiable) {

    }
}
