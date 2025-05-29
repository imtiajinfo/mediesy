<?php

namespace App\Jobs;

use App\Mail\OrderShipped;
use App\Models\OrderMaster;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;


class SendOrderShippedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $details = "sharif.uddin.997766@gmail.com"; // data needed for the email;
        $email = new OrderShipped($details);
        Mail::to($details['recipient'])->send($email);


        // Retrieve orders with status = "shipped"
        $shippedOrders = OrderMaster::where('status', 'Delivered')->get();

        foreach ($shippedOrders as $order) {
            // Send email for each shipped order
            $details = [
                'order' => $order, // Pass the order details to the email template
            ];

            Mail::to($order->email)->send(new OrderShipped($details));
        }


        // Dispatch the job
        SendOrderShippedEmail::dispatch()->onQueue('emails');
    }
}
