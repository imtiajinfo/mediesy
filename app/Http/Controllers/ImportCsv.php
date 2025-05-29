<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Jobs\ImportCsvJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class ImportCsv extends Controller
{

    public function index()
    {
        return view('admin.importcsv.index');
    }

    public function upload_csv_file(Request $request)
    {

        // if ($request->has('csv_file')) {

        //     $csv    = file($request->csv_file);
        //     $chunks = array_chunk($csv, 1000);
        //     $header = [];
        //     $batch  = Bus::batch([])->dispatch();

        //     foreach ($chunks as $key => $chunk) {
        //         $data = array_map('str_getcsv', $chunk);
        //         if ($key == 0) {
        //             $header = $data[0];
        //             unset($data[0]);
        //         }
        //         $batch->add(new ImportCsvJob($data, $header));
        //     }
        //     return $batch;

        // }
        // return "please upload csv file";

        $request->validate([
            'csv_file' => 'required|mimes:sql,csv,txt|max:51200', // Adjust file size or types as necessary
        ]);

        if ($request->file('csv_file')->isValid()) {
            $file = $request->file('csv_file');
            $originalExtension = $file->getClientOriginalExtension();
            $fileName = 'uploaded_time' . time() . '_rand' . mt_rand(1000000, 9999999) . '.' . $originalExtension; // Unique file name with original extension

            $filePath = $file->storeAs('public/csv', $fileName); // Store the file in the storage/csv directory with the generated name

            // Dispatch a job to process the uploaded CSV file
            ImportCsvJob::dispatch($filePath);

            return redirect()->back()->with('success', 'CSV file has been uploaded and is being processed.');
        } else {
            return redirect()->back()->with('error', 'Invalid file uploaded.');
        }
        // Handle errors or provide appropriate feedback to the user
    }
}
