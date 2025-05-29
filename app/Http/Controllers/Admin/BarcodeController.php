<?php

namespace App\Http\Controllers\Admin;

// use DNS1D;
use PDF;
use Mpdf\Mpdf;
use App\Models\ItemInfo;
use Milon\Barcode\DNS1D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class BarcodeController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = ItemInfo::chunk(200, function ($items) {
            foreach ($items as $item) {
                $item->generateAndSaveBarcode();
            }
        });
        $products = ItemInfo::all();

        if ($products === false) {
            // Handle the query failure, log the error, or return an appropriate response
            return response()->json(['error' => 'Failed to retrieve products'], 500);
        }
        return view('admin.bar_code.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = ItemInfo::all();
        return view('admin.bar_code.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            ini_set('memory_limit', '256M'); // Set to an appropriate value

            $id = $request->product_id;
            $qty = $request->quantity;
            $product = ItemInfo::findOrFail($id);
            $products = ItemInfo::all();

            if (!$request->has('product_id') || !$request->has('quantity')) {
                abort(400, 'Invalid request parameters');
            }

            if (!$product) {
                abort(404, 'Product not found');
            }

            $batchSize = 500;
            $barcodes = [];

            for ($start = 0; $start < $qty; $start += $batchSize) {
                $end = min($start + $batchSize, $qty);

                for ($i = $start; $i < $end; $i++) {
                    $barcodeValue = $product->code;

                    try {
                        $barcodeHTML = DNS1D::getBarcodeHTML($barcodeValue, 'C39', 1.2, 50, 'green', true);
                        $barcodes[] = $barcodeHTML;
                    } catch (\Exception $e) {
                        // Log the exception or handle it as needed
                        // For example, you can log an error message and continue to the next iteration
                        Log::error('Exception during barcode generation: ' . $e->getMessage());
                        continue;
                    }
                }
            }

            return view('admin.bar_code.create')->with([
                'products' => $products,
                'barcodes' => $barcodes,
                'barcodeproduct' => $product,
                'qty' => $qty,
            ]);
        } catch (\Exception $e) {
            // Log or handle the exception
            return response()->json(['error' => 'An error occurred during barcode generation.']);
        }
    }



    public function store1(Request $request)
    {
        try {
            $id = $request->product_id;
            $quantity = $request->quantity;

            if (!$request->has('product_id') || !$request->has('quantity')) {
                abort(400, 'Invalid request parameters');
            }

            $product = ItemInfo::findOrFail($id);

            if (!$product) {
                abort(404, 'Product not found');
            }

            $qty = (int)$quantity; // Ensure quantity is an integer
            $batchSize = 1000;
            $outputFile = 'barcodes.html';

            ini_set('memory_limit', '256M'); // Set to an appropriate value

            $handle = fopen($outputFile, 'w');
            fwrite($handle, '<div class="barcode-container">');

            for ($start = 0; $start < $qty; $start += $batchSize) {
                $end = min($start + $batchSize, $qty);

                for ($i = $start; $i < $end; $i++) {
                    $barcodeValue = $product->code;

                    try {
                        $barcodeHTML = DNS1D::getBarcodeHTML($barcodeValue, 'C39', 1.3, 55, 'green', true);
                        fwrite($handle, '<div class="barcode-item">' . $barcodeHTML . '</div>');
                    } catch (\Exception $e) {
                        // Log the exception or handle it as needed
                        // For example, log an error message and continue to the next iteration
                        Log::error('Exception during barcode generation: ' . $e->getMessage());
                        continue;
                    }
                }
            }

            fwrite($handle, '</div>');
            fclose($handle);

            return response()->download($outputFile)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            // Handle general exceptions here
            // Log::error('Exception in barcode generation process: ' . $e->getMessage());
            abort(500, 'Internal Server Error');
        }
    }



    public function BarcodePdf(Request $request)
    {

        try {
            $id = $request->product_id;
            $quantity = $request->quantity;
            $qty = (int)$quantity; // Ensure quantity is an integer 

            if (!$request->has('product_id') || !$request->has('quantity')) {
                abort(400, 'Invalid request parameters');
            }

            $data = ItemInfo::findOrFail($id);

            if (!$data) {
                abort(404, 'Product not found');
            }
            ini_set('memory_limit', '256M'); // Set to an appropriate value 
            ini_set("pcre.backtrack_limit", "5000000000000000000");
            ini_set("memory_limit", "4096M");
            ini_set('max_execution_time', 600);


            $batchSize = 500;
            $barcodes = [];

            for ($start = 0; $start < $qty; $start += $batchSize) {
                $end = min($start + $batchSize, $qty);

                for ($i = $start; $i < $end; $i++) {
                    $barcodeValue = $data->code;

                    try {
                        // $barcodeHTML = DNS1D::getBarcodeHTML($barcodeValue, 'C39', 1.3, 55, 'green', true);
                        // $barcodeHTML = DNS1D::getBarcodeHTML($barcodeValue, 'C39+', 1, 50, 'black', true);

                        $barcodeHTML = $data->code;
                        $barcodes[] = $barcodeHTML;
                    } catch (\Exception $e) {
                        Log::error('Exception during barcode generation: ' . $e->getMessage());
                        continue;
                    }
                }
            }
            // dd($barcodes);

            //$filename = $data[0]->name.'.pdf';
            $filename = $data->name . '.pdf';
            $pdf = PDF::loadView('admin.bar_code.barcodePdf', ['data' => $data, 'barcodes' => $barcodes], [], [
                'mode' => '',
                'format' => 'A4-P',
                'default_font_size' => '12',
                'default_font' => 'SutonnyMJRegular',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_header' => 2,
                'margin_footer' => 10,
                'orientation' => 'L',
                'title' => 'Laravel mPDF',
                'author' => '',
                'watermark' => '',
                'show_watermark' => true,
                'watermark_font' => 'SutonnyMJRegular',
                'display_mode' => 'fullpage',
                'watermark_text_alpha' => 0.2,
                'custom_font_dir' => '',
                'custom_font_data' => [],
                'auto_language_detection' => false,
                'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                'pdfa' => false,
                'pdfaauto' => false,
            ]);

            return $pdf->stream($filename . '.pdf');
        } catch (\Exception $e) {
            // Handle general exceptions here
            dd($e->getMessage());
            Log::error('Exception in barcode generation process: ' . $e->getMessage());
            abort(500, 'Internal Server Error');
        }
    }

    public function BarcodePdf3(Request $request)
    {

        try {
            $id = $request->product_id;
            $quantity = $request->quantity;
            $qty = (int)$quantity; // Ensure quantity is an integer 

            if (!$request->has('product_id') || !$request->has('quantity')) {
                abort(400, 'Invalid request parameters');
            }

            $data = ItemInfo::findOrFail($id);

            if (!$data) {
                abort(404, 'Product not found');
            }
            ini_set('memory_limit', '256M'); // Set to an appropriate value 
            ini_set("pcre.backtrack_limit", "5000000000000000000");
            ini_set("memory_limit", "4096M");
            ini_set('max_execution_time', 600);


            $batchSize = 500;
            $barcodes = [];

            for ($start = 0; $start < $qty; $start += $batchSize) {
                $end = min($start + $batchSize, $qty);

                for ($i = $start; $i < $end; $i++) {
                    $barcodeValue = $data->code;

                    try {
                        // $barcodeHTML = DNS1D::getBarcodeHTML($barcodeValue, 'C39', 1.3, 55, 'green', true);
                        // $barcodeHTML = DNS1D::getBarcodeHTML($barcodeValue, 'CODE128', 1.3, 55, 'green', true);
                        $barcodeHTML =  $data->code;

                        $barcodes[] = $barcodeHTML;
                    } catch (\Exception $e) {
                        // Log the exception or handle it as needed
                        // For example, you can log an error message and continue to the next iteration
                        Log::error('Exception during barcode generation: ' . $e->getMessage());
                        continue;
                    }
                }
            }


            //$filename = $data[0]->name.'.pdf';
            $filename = $data->name . '.pdf';
            $pdf = PDF::loadView('admin.bar_code.barcodePdf', ['data' => $data, 'barcodes' => $barcodes,], [], [
                'mode' => '',
                'format' => 'A4-P',
                'default_font_size' => '12',
                'default_font' => 'SutonnyMJRegular',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_header' => 2,
                'margin_footer' => 10,
                'orientation' => 'L',
                'title' => 'Laravel mPDF',
                'author' => '',
                'watermark' => '',
                'show_watermark' => true,
                'watermark_font' => 'SutonnyMJRegular',
                'display_mode' => 'fullpage',
                'watermark_text_alpha' => 0.2,
                'custom_font_dir' => '',
                'custom_font_data' => [],
                'auto_language_detection' => false,
                'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                'pdfa' => false,
                'pdfaauto' => false,
            ]);

            return $pdf->stream($filename . '.pdf');
        } catch (\Exception $e) {
            // Handle general exceptions here
            dd($e->getMessage());
            Log::error('Exception in barcode generation process: ' . $e->getMessage());
            abort(500, 'Internal Server Error');
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }




    public function generatePDF()
    {
        // return  $this->generateBarcodes();
        try {
            ini_set('memory_limit', '256M'); // Set to an appropriate value


            // Your data to be included in the PDF
            $data = [
                'title' => 'Sample PDF Document',
                'content' => 'This is the content of the PDF document.',
            ];

            // Generate barcodes
            $barcodes = $this->generateBarcodes();

            // Add barcode data to the PDF data
            $data['barcodes'] = $barcodes;

            // Create an mPDF instance
            $mpdf = new Mpdf();

            // Load a view into mPDF
            $view = view('admin.bar_code.barcodePdf', $data)->render();
            // Split the HTML into chunks (adjust the chunk size as needed)

            $chunkSize = 300;
            $htmlChunks = str_split($view, $chunkSize);

            // Call WriteHTML for each chunk
            foreach ($htmlChunks as $chunk) {
                $mpdf->WriteHTML($chunk);
            }


            // Save the PDF to a file
            $outputPath = storage_path('app/public/sample.pdf'); // Adjust the path as needed
            $mpdf->Output($outputPath, 'F');

            // Provide download link or redirect to the file
            return response()->json(['success' => 'PDF generated successfully', 'pdf_url' => asset('storage/sample.pdf')]);
        } catch (\Exception $e) {
            // Log or handle the exception
            Log::error('Exception during PDF generation: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred during PDF generation.', $e->getMessage()]);
        }
    }
    private function generateBarcodes()
    {
        // Your barcode generation logic using DNS1D library
        $id = 1; // Example product ID
        $qty = 50; // Example quantity
        $product = ItemInfo::findOrFail($id);

        $batchSize = 400;
        $barcodes = [];

        for ($start = 0; $start < $qty; $start += $batchSize) {
            $end = min($start + $batchSize, $qty);

            for ($i = $start; $i < $end; $i++) {
                $barcodeValue = $product->code;
                try {
                    $barcodeHTML = $barcodeValue;

                    // Log barcode value and HTML
                    Log::info('Barcode Value: ' . $barcodeValue);
                    Log::info('Barcode HTML: ' . $barcodeHTML);

                    $barcodes[] = $barcodeHTML;
                } catch (\Exception $e) {
                    // Log the exception or handle it as needed
                    Log::error('Exception during barcode generation: ' . $e->getMessage());
                    continue;
                }
            }
        }
        return $barcodes;
    }
}
