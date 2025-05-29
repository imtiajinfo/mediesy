<?php

namespace App\Jobs;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ImportCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        try {
            $file = fopen(Storage::path($this->filePath), 'r');
            $header = fgetcsv($file);

            $data = [];
            while (($row = fgetcsv($file)) !== false) {
                $rowData = array_combine($header, $row);
                $data[] = $rowData;
            }
            fclose($file);

            foreach ($data as &$category) {
                // Assuming 'parent_id' might be coming as a string 'NULL'
                if ($category['parent_id'] === 'NULL') {
                    $category['parent_id'] = null; // Convert string 'NULL' to actual null
                } else {
                    // If the 'parent_id' is an integer represented as a string
                    $category['parent_id'] = (int)$category['parent_id']; // Convert to an integer
                }
            }
            // Adjust the data array to exclude the 'id' column
            $filteredData = collect($data)->map(function ($item) {
                unset($item['id']);
                return $item;
            })->values()->all();

            // Chunk the data and perform the insert in smaller sets
            $chunkedData = array_chunk($filteredData, 500);

            // Use a transaction to ensure data integrity
            DB::beginTransaction();
            foreach ($chunkedData as $chunk) {
                Category::insert($chunk); // Insert the chunked data into the database
            }

            // Category::insert($filteredData); // Insert the modified data into the database 
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error processing CSV job: " . $e->getMessage());
            // Handle the exception or log it for investigation
            throw $e;
        }
    }


    // protected $filePath;

    // public function __construct($filePath)
    // {
    //     $this->filePath = $filePath;
    // }


    /**
     * Execute the job.
     */
    // public function handle(): void
    // {

    //     // Your code to process the CSV file and insert into the database

    //     $file = fopen($this->filePath, 'r');
    //     $header = fgetcsv($file); // Assuming the first row contains column headers

    //     $data = [];
    //     while (($row = fgetcsv($file)) !== false) {
    //         $rowData = array_combine($header, $row);
    //         $data[] = $rowData;
    //     }
    //     fclose($file);

    //     // Use a transaction to ensure data integrity
    //     DB::beginTransaction();
    //     try {
    //         Category::insert($data); // Bulk insert data into the database using Eloquent

    //         // If needed, you can add more processing here

    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         // Handle the exception, log the error, or perform necessary actions
    //         throw $e;
    //     }
    // }
}
