<?php

// app/Listeners/SendOrderDeliveredEmail.php
namespace App\Listeners;

use App\Mail\OrderShipped;
use App\Events\OrderDelivered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderDeliveredEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(OrderDelivered $event)
    {
        $order = $event->order;

        try {
            if ($order->order_status === 'Delivered') {
                Mail::to($order->email)->send(new OrderShipped($order));
            }
        } catch (\Exception $e) {
            Log::error('Error sending order delivered email: ' . $e->getMessage());
        }
    }
}
