<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BrtDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $brt;
    /**
     * Create a new event instance.
     */
    public function __construct($brt)
    {
        //
        $this->brt = $brt;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('brts');
    }

    public function broadcastWith()
    {
        $brt_arr = json_decode($this->brt, true);
        return ['message' => "DELETED BRT {$brt_arr['reserved_amount']} BLUME COIN", 'id' => $brt_arr['id']];
    }

    /** * Get the name the event should broadcast as. 
     *  
     * @return string 
     */
    public function broadcastAs()
    {
        return 'BrtDeleted';
    }
}
