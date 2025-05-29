<?php

namespace App\Listeners;

use App\Models\Order;
use App\Events\NewOrderPlaced;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewOrderNotification
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
    public function handle(NewOrderPlaced $event)
    {
        $order = $event->order;

        // Logic to send notification (e.g., email notification)
        // Replace with your notification logic, this is an example using mail
        $user = $order->user; // Assuming the order is associated with a user
        $user->notify(new NewOrderNotification($order));
    }
}
