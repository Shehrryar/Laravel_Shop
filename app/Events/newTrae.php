<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class newTrae
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $trade;
    /**
     * Create a new event instance.
     */
    public function __construct($trade)
    {
        $this->trade = $trade;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // new PrivateChannel('channel-name'),
            new Channel('trades'),
        ];
    }
}
