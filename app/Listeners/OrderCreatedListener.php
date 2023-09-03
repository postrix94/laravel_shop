<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Jobs\OrderCreatedNotifyJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreatedEvent $event): void
    {
        OrderCreatedNotifyJob::dispatch($event->order)->onQueue('notifications');
    }
}
