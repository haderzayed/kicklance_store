<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\NewOrderMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function handle(OrderCreated $event)
    {
        $order=$event->order;
        $users=User::where('type','super_admin')->get();
        if(! $users){
            return;
        }
        Mail::to($users)->send(new NewOrderMail($order));
    }
}
