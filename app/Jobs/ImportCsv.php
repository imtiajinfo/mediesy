<?php

namespace App\Jobs;

use Throwable;
use App\Models\Category;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ImportCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $header)
    { //
    }



    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if ($this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...

            return;
        }

        $batch = Bus::batch([
            new ImportCsv(1, 100),
            new ImportCsv(101, 200),
            new ImportCsv(201, 300),
            new ImportCsv(301, 400),
            new ImportCsv(401, 500),
        ])->then(function (Batch $batch) {
            // All jobs completed successfully...
        })->catch(function (Batch $batch, Throwable $e) {
            // First batch job failure detected...
        })->finally(function (Batch $batch) {
            // The batch has finished executing...
        })->dispatch();

        return $batch->id;
    }
}
