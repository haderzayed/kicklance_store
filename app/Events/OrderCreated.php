<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct($order)
    {
         $this->order=$order;
    }


    public function broadcastOn()
    {
        //event name
        return new PrivateChannel('orders');
    }
    public function broadcastAs(){
        //alias name for event name
        return 'order-created';
    }
    public function broadcastWith(){
        //send data with event inested of public properties
        return [
            'order'=>$this->order,
            'user'=>Auth::user(),
        ] ;
    }
}
