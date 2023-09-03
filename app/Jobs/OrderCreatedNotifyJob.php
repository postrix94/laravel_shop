<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Notifications\Orders\Created\AdminNotification;
use App\Notifications\Orders\Created\CustomerNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCreatedNotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Order $order;
    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->order->notify(app()->make(CustomerNotification::class));
        \Notification::send(User::role('admin')->get(), app()->make(AdminNotification::class));
    }
}
