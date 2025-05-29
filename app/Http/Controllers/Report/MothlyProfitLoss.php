<?php

namespace App\Http\Controllers\Report;

use PDF;
use App\Models\Sell;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\ItemInfo;
use Illuminate\Http\Request;
use App\Models\DailyExpenses;
use App\Models\PurchaseOrders;
use App\Models\PaymentToSupplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MothlyProfitLoss extends Controller
{
    public function index(Request $request)
    {
        return view('admin.reports.mothlyProfitLoss.mothlyProfitLossDetails');
    }


    public function find(Request $request)
    {

        try {
            $to_date = $request->input('to_date');
            $from_date = $request->input('from_date');

            if (!$request->has('to_date') && !$request->has('from_date')) {
                abort(400, 'Invalid request parameters');
            }


            $DailyExpenses = DailyExpenses::select([
                'expense_name',
                'expense_group',
                'company',
                'store',
                'expense_date',
                'amount'
            ])
                ->whereBetween('created_at', [$to_date, $from_date])
                ->where('approved_status', "Approved")
                ->get();
            $AllpurchaseOrders = PurchaseOrders::whereBetween('created_at', [$to_date, $from_date])
                ->where('is_received', 1)->get();

            $Allsales = Sell::whereBetween('created_at', [$to_date, $from_date])->where('sells_status', 1)->get();



            // Fetch data from the database
            $purchaseOrders = PurchaseOrders::whereBetween('created_at', [$to_date, $from_date])
                ->where('is_received', 1)->sum('total_purchase_amount');
            $sales = Sell::whereBetween('created_at', [$to_date, $from_date])->where('sells_status', 1)->sum('payable');

            // $sales = Sell::whereBetween('created_at', [$to_date, $from_date])
            // ->where('sells_status', 1)
            // ->leftJoin('items', 'sells.item_id', '=', 'items.id') // Assuming 'id' is the primary key in the 'items' table
            // ->sum('sells.sell_price') - Item::whereBetween('items.created_at', [$to_date, $from_date])
            // ->where('items.sells_status', 1)
            // ->sum('items.purchase_price');


            $expenses = DailyExpenses::whereBetween('created_at', [$to_date, $from_date])->where('approved_status', "Approved")->sum('amount');

            // Calculate profit and loss
            $totalIncome = $sales;
            $totalExpense =  $expenses;
            $netProfitLoss = $totalIncome - $totalExpense;

            // Return or display the report
            return view('admin.reports.mothlyProfitLoss.mothlyProfitLossDetails', with([
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
                'netProfitLoss' => $netProfitLoss,
                'DailyExpenses' => $DailyExpenses,
                'AllpurchaseOrders' => $AllpurchaseOrders,
                'Allsales' => $Allsales,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'purchaseOrders' => $purchaseOrders,
            ]));
        } catch (\Exception $e) {
            // Log or handle the exception
            return response()->json(['error' => 'An error occurred during transaction generation.']);
        }
    }


    public function transPdf(Request $request)
    {
        $to_date = $request->input('to_date');
        $from_date = $request->input('from_date');

        if (!$request->has('to_date') && !$request->has('from_date')) {
            abort(400, 'Invalid request parameters');
        }


        $DailyExpenses = DailyExpenses::select([
            'expense_name',
            'expense_group',
            'company',
            'store',
            'expense_date',
            'amount'
        ])
            ->whereBetween('created_at', [$to_date, $from_date])
            ->where('approved_status', "Approved")
            ->get();
        $AllpurchaseOrders = PurchaseOrders::whereBetween('created_at', [$to_date, $from_date])
            ->where('is_received', 1)->get();

        $Allsales = Sell::whereBetween('created_at', [$to_date, $from_date])->where('sells_status', 1)->get();



        // Fetch data from the database
        $purchaseOrders = PurchaseOrders::whereBetween('created_at', [$to_date, $from_date])
            ->where('is_received', 1)->sum('total_purchase_amount');
        $sales = Sell::whereBetween('created_at', [$to_date, $from_date])->where('sells_status', 1)->sum('payable');
        $expenses = DailyExpenses::whereBetween('created_at', [$to_date, $from_date])->where('approved_status', "Approved")->sum('amount');

        // Calculate profit and loss
        $totalIncome = $sales;
        $totalExpense =  $expenses;
        $netProfitLoss = $totalIncome - $totalExpense;
        // dd($transaction);

        $filename =  $to_date . $from_date . '.pdf';
        $pdf = PDF::loadView('admin.reports.mothlyProfitLoss.mothlyProfitLossDetailsPDF', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netProfitLoss' => $netProfitLoss,
            'DailyExpenses' => $DailyExpenses,
            'AllpurchaseOrders' => $AllpurchaseOrders,
            'Allsales' => $Allsales,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'purchaseOrders' => $purchaseOrders,
        ], [], [
            'mode' => '',
            'format' => 'A4-P',
            'default_font_size' => '12',
            'default_font' => 'SutonnyMJRegular',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_header' => 2,
            'margin_footer' => 2,
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
