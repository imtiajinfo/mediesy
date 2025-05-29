<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\BulkEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendBulkEmails implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;


    public function handle()
    {
        try {
            $users = User::all(); // Fetch the users or the desired collection of users
            foreach ($users as $user) {
                Mail::to($user->email)->queue(new BulkEmail($user));
            }
            // $users->chunk(50, function ($userChunk) {
            //     foreach ($userChunk as $user) {
            //         try {
            //             Mail::to($user->email)->queue(new BulkEmail($user));
            //         } catch (\Exception $e) {
            //             Log::error('Error sending email to ' . $user->email . ': ' . $e->getMessage());
            //         }
            //     }
            // });

            // $users = User::cursor();
            // $chunkSize = 1000;

            // $delay = 10; // Delay in seconds between each job

            // $users->chunk($chunkSize, function ($userChunk) use ($delay) {
            //     foreach ($userChunk as $user) {
            //         SendBulkEmails::dispatch($user)->onQueue('email:send-bulk')->delay(now()->addSeconds($delay));
            //         // Mail::to($user->email)->queue(new BulkEmail($user));
            //     }
            // });
            return "Bulk emails are being sent to all users in chunks of 50!";
        } catch (\Exception $e) {
            // Log the error or handle the exception as needed
            Log::error('Error sending bulk emails: ' . $e->getMessage());
            // return "Error sending bulk emails: " . $e->getMessage();
        }
    }
}
