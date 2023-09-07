<?php

namespace App\Events;

use AWS\CRT\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class UserNotify implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithBroadcasting;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
        $this->broadcastVia('pusher');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('my-channel');
    }

}
