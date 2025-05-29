<?php

namespace App\Jobs;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class BatchDataInsertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // protected $chunkSize;
    // protected $totalRecords;

    // public function __construct($chunkSize, $totalRecords)
    // {
    //     $this->chunkSize = $chunkSize;
    //     $this->totalRecords = $totalRecords;
    // }

    public function __construct()
    {
        //
    }
    // public function uniqueId()
    // {
    //     return $this->count;
    // }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();
        try {


            DB::transaction(function () {
                $chunkSize = 400; // Adjust the batch size as needed
                $brandData = Brand::factory()->count($chunkSize)->create()->toArray();
                $categoryData = Category::factory()->count($chunkSize)->create()->toArray();
                $sizeData = Size::factory()->count($chunkSize)->create()->toArray();

                // Brand::insert($brandData);
                // Size::insert($sizeData);
                // Category::insert($categoryData); 
            });

            // Brand::withoutEvents(function () {
            //     factory(Brand::class, $this->chunkSize)->create();
            // });

            // Simulate an error by throwing an exception
            // throw new \Exception('Simulated job failure');

            DB::commit();
        } catch (\Exception $e) {
            echo "Error occurred while inserting records: " . $e->getMessage() . "\n";
            DB::rollback();
            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();
            echo "Throwabled while inserting records: " . $e->getMessage() . "\n";
        }
    }


    public function failed(\Exception $exception)
    {
        // Log or handle the failure here
        Log::error('Job failed: ' . $exception->getMessage());
    }
}
