<?php

namespace App\Notifications;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use  \Illuminate\Notifications\Messages\NexmoMessage;

class OrderCreatedNotification extends Notification
{
    use Queueable;
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order=$order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // notifiable => user that receive notification
        // mail ,database,broadcast,nexmo ,slack
        return ['mail','database','broadcast','nexmo'];
    }


   public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Order')
                    ->greeting('Hello, '. $notifiable->name)
                    ->line( "A new order has created for you (order #{$this->order->id}) ")
                    ->action('view order', URL::route('order.show',$this->order->id))
                    ->line('Thank you for purchase!');
    }
    public function toDatabase($notifiable){
        return[
            'title'=>'New Order',
            'body'=>"A new order has created for you (order #{$this->order->id}) ",
            'action'=> URL::route('order.show',$this->order->id),
            'icon'=>'',
        ];

    }

    public function toBroadcast($notifiable){
        return new BroadcastMessage([
            'title'=>'New Order',
            'body'=>"A new order has created for you (order #{$this->order->id}) ",
            'action'=> URL::route('order.show',$this->order->id),
            'icon'=>'',
            'order'=>$this->order,
            'time'=>Carbon::now(),
            'user'=>Auth::user(),
        ]);

    }

    public function toNexmo($notifiable)
    {
        $message=new NexmoMessage();
        return $message->content("A new order has created for you");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
