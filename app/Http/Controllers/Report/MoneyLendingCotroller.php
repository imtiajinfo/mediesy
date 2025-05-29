<?php

namespace App\Http\Controllers\Report;

use PDF;
use App\Models\Sell;
use App\Models\Customer;
use App\Models\ItemInfo;
use App\Models\MoneyLending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MoneyLendingCotroller extends Controller
{
    public function index(Request $request)
    {
        return view('admin.reports.moneyLending.moneyLendingDetails');
    }


    public function find(Request $request)
    {

        try {
            $to_date = $request->input('to_date');
            $from_date = $request->input('from_date');

            if (!$request->has('to_date') && !$request->has('from_date')) {
                abort(400, 'Invalid request parameters');
            }

            $fields = [
                'id',
                'name',
                'name_bangla',
                'email',
                'phone',
                'nid',
                'country',
                'division',
                'district',
                'city',
                'Area',
                'postcode',
                'parent_address',
                'permanent_address',
                'from_date',
                'to_date',
                'to_amount',
                'recv_amount',
                'due_amount',
                'monthly_profit',
                'is_closed',
            ];

            $MoneyLendings = MoneyLending::select($fields)
                ->whereBetween('created_at', [$to_date, $from_date])
                // ->where('is_closed', '=' ? 1 : 0)
                ->get();

            return view('admin.reports.moneyLending.moneyLendingDetails')->with([
                'MoneyLendings' => $MoneyLendings,
                'from_date' => $from_date, 'to_date' => $to_date,
            ]);
        } catch (\Exception $e) {
            // Log or handle the exception
            return response()->json(['error' => 'An error occurred during transaction generation.']);
        }
    }


    public function transPdf(Request $request)
    {

        try {

            $to_date = $request->input('to_date');
            $from_date = $request->input('from_date');

            if (!$request->has('to_date') && !$request->has('from_date')) {
                abort(400, 'Invalid request parameters');
            }

            $fields = [
                'id',
                'name',
                'name_bangla',
                'email',
                'phone',
                'nid',
                'country',
                'division',
                'district',
                'city',
                'Area',
                'postcode',
                'parent_address',
                'permanent_address',
                'from_date',
                'to_date',
                'to_amount',
                'recv_amount',
                'due_amount',
                'monthly_profit',
                'is_closed',
            ];

            $MoneyLendings = MoneyLending::select($fields)
                ->whereBetween('created_at', [$to_date, $from_date])
                // ->where('is_closed', '=' ? 1 : 0)
                ->get();
            ini_set('memory_limit', '256M');

            $to_date = $request->input('to_date');
            $from_date = $request->input('from_date');

            if (!$request->has('to_date') && !$request->has('from_date')) {
                abort(400, 'Invalid request parameters');
            }

            $fields = [
                'id',
                'name',
                'name_bangla',
                'email',
                'phone',
                'nid',
                'country',
                'division',
                'district',
                'city',
                'Area',
                'postcode',
                'parent_address',
                'permanent_address',
                'from_date',
                'to_date',
                'to_amount',
                'recv_amount',
                'due_amount',
                'monthly_profit',
                'is_closed',
            ];

            $MoneyLendings = MoneyLending::select($fields)
                ->whereBetween('created_at', [$to_date, $from_date])
                // ->where('is_closed', '=' ? 1 : 0)
                ->get();


            // dd($transaction);

            $filename = $to_date . $from_date . '.pdf';
            $pdf = PDF::loadView('admin.reports.moneyLending.moneyLendingDetailsPDF', [
                'MoneyLendings' => $MoneyLendings,
                'from_date' => $from_date, 'to_date' => $to_date,
            ], [], [
                'mode' => '',
                'format' => 'A4-L',
                'default_font_size' => '13',
                'default_font' => 'SutonnyMJRegular',
                'margin_left' => 10,
                'margin_right' => 10,
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
        } catch (\Exception $e) {
            // Handle general exceptions here
            dd($e->getMessage());
            Log::error('Exception in transaction generation process: ' . $e->getMessage());
            abort(500, 'Internal Server Error');
        }
    }
}
