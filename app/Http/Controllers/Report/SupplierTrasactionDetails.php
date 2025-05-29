<?php

namespace App\Http\Controllers\Report;

use PDF;
use App\Models\ItemInfo;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseOrders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class SupplierTrasactionDetails extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::all();
        return view('admin.reports.supplier.supplierTrasactionDetails', with(['suppliers' => $suppliers]));
    }


    public function find(Request $request)
    {

        try {
            ini_set('memory_limit', '256M');
            $id = $request->input('supplier_id');
            $to_date = $request->input('to_date');
            $from_date = $request->input('from_date');

            if (!$request->has('supplier_id') || !$request->has('to_date') && !$request->has('from_date')) {
                abort(400, 'Invalid request parameters');
            }

            $findSupplier = Supplier::findOrFail($id);
            if (!$findSupplier) {
                abort(404, 'Supplier not found');
            }

            $suppliers = Supplier::all();

            $tdForSupplier = PurchaseOrders::where('supplier_id', $id)
                ->whereBetween('created_at', [$to_date, $from_date])
                ->select(['id', 'supplier_id', 'total_purchase_qty', 'total_received_qty', 'total_purchase_amount'])
                ->get();

            // dd($findSupplier);
            $batchSize = 500;
            $transaction = [];

            for ($start = 0; $start < $to_date; $start += $batchSize) {
                $end = min($start + $batchSize, $to_date);

                for ($i = $start; $i < $end; $i++) {
                    $transactionValue = $tdForSupplier;
                    try {
                        $transaction[] = $transactionValue;
                    } catch (\Exception $e) {
                        Log::error('Exception during transaction generation: ' . $e->getMessage());
                        continue;
                    }
                }
            }

            return view('admin.reports.supplier.supplierTrasactionDetails')->with([
                'findSupplier' => $findSupplier,
                'suppliers' => $suppliers,
                'tdForSupplier' => $tdForSupplier,
                'from_date' => $from_date, 'to_date' => $to_date, 'id' => $id,
            ]);
        } catch (\Exception $e) {
            // Log or handle the exception
            return response()->json(['error' => 'An error occurred during transaction generation.']);
        }
    }


    public function transPdf(Request $request)
    {

        // try {
        ini_set('memory_limit', '256M');
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit", "4096M");
        ini_set('max_execution_time', 600);

        $id = $request->input('supplier_id');
        $to_date = $request->input('to_date');
        $from_date = $request->input('from_date');



        $findSupplier = Supplier::findOrFail($id);

        if (!$findSupplier) {
            abort(404, 'Supplier not found');
        }

        $tdForSupplier = PurchaseOrders::where('supplier_id', $id)
            ->whereBetween('created_at', [$to_date, $from_date])
            ->select(['id', 'supplier_id', 'total_purchase_qty', 'total_received_qty', 'total_purchase_amount'])
            ->get();

        $batchSize = 500;
        $transaction = [];

        // Split the $tdForSupplier collection into batches
        $chunks = $tdForSupplier->chunk($batchSize);

        foreach ($chunks as $chunk) {
            foreach ($chunk as $value) {
                try {
                    $transaction[] = $value;
                } catch (\Exception $e) {
                    Log::error('Exception during transaction generation: ' . $e->getMessage());
                    continue;
                }
            }
        }


        // dd($transaction);

        $filename = $findSupplier->name . '.pdf';
        $pdf = PDF::loadView('admin.reports.supplier.supplierTrasactionDetailsPDF', ['data' => $findSupplier, 'transaction' => $transaction], [], [
            'mode' => '',
            'format' => 'A4-P',
            'default_font_size' => '12',
            'default_font' => 'SutonnyMJRegular',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_header' => 2,
            'margin_footer' => 15,
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
            'debug' => true,
        ]);

        return $pdf->stream($filename . '.pdf');
        // } catch (\Exception $e) {
        //     // Handle general exceptions here
        //     dd($e->getMessage());
        //     Log::error('Exception in transaction generation process: ' . $e->getMessage());
        //     abort(500, 'Internal Server Error');
        // }
    }
}
