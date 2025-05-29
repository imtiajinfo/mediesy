<?php
// routes/admin.php 

use App\Models\Sell;
use App\Mail\OrderShipped;
use App\Models\PointOfSale;
use App\Models\ItemStoreMapping;
use App\Http\Controllers\ImportCsv;
use App\Http\Controllers\ClearCache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\DataController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\AdminsControllers;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SellController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\OrderShipedController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\Admin\HK\UomController;
use App\Http\Controllers\AddressFilterController;
use App\Http\Controllers\Admin\BarcodeController;
use App\Http\Controllers\Admin\HK\ColorContrller;
use App\Http\Controllers\Admin\HK\SizeController;
use App\Http\Controllers\Report\MothlyProfitLoss;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HK\BrandController;
use App\Http\Controllers\Admin\HK\ColorController;
use App\Http\Controllers\Admin\HK\StoreController;
use App\Http\Controllers\Admin\ItemInfoController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\WarrantyController;
use App\Http\Controllers\NewOrderPlacedController;
use App\Http\Controllers\Admin\HK\UomSetController;
use App\Http\Controllers\Admin\itemStoreController;
use App\Http\Controllers\Admin\HK\ExpenseController;
use App\Http\Controllers\Admin\HK\BankInfoController;
use App\Http\Controllers\Admin\HK\CategoryController;
use App\Http\Controllers\Admin\PointOfSaleController;
use App\Http\Controllers\Admin\ServiceSellController;
use App\Http\Controllers\Admin\MoneyLendingController;
use App\Http\Controllers\Report\MoneyLendingCotroller;
use App\Http\Controllers\Admin\DailyExpensesController;
use App\Http\Controllers\Admin\OpeningBalanceController;
use App\Http\Controllers\Admin\PurchaseOrdersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Report\CustomerTrasactionDetails;
use App\Http\Controllers\Report\SupplierTrasactionDetails;
use App\Http\Controllers\Admin\GetAllModuleDataConntroller;
use App\Http\Controllers\Admin\PurchaseReturnController;
use App\Http\Controllers\Admin\SaleReturnController;
use App\Http\Controllers\Admin\HK\ItemStoreMappingController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
// reports 
use  App\Http\Controllers\Report\SellsLedgerController;
use  App\Http\Controllers\Report\PurchaseLedgerController;
use  App\Http\Controllers\Report\ExpenseController as ExpenseControllerReport;
use  App\Http\Controllers\Report\StockLedgerController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',  // 'middleware' => 'routePermission:permission1,permission2'
])->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('home');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/migrate', function () {
        Artisan::call('migrate');
        dd("Success Migrate!");
    });
    Route::get('/db-seed', function () {
        Artisan::call('db:seed');
        dd("Success Seed!");
    });

    // // HK-01:manage Category
    Route::resource('categories', CategoryController::class);
    Route::get('categories/{category:slug}/edit', [CategoryController::class, 'edit'])->name('categories.edits');

    // uom-set Routes
    Route::get('/uom/set', function () {
        return view('admin.uom-set.index');
    })->name('uom-set');

    // uom Routes
    Route::get('/uom', function () {
        return view('admin.uom.index');
    })->name('uom');

    // seller Routes
    Route::get('/seller', function () {
        return view('admin.seller.index');
    })->name('seller');

    // products Routes
    Route::get('/products', function () {
        return view('admin.products.index');
    })->name('products');

    // product-create Routes
    Route::get('/product/create', function () {
        return view('admin.products.create');
    })->name('product-create');

    // product-edit Routes
    Route::get('/product/edit', function () {
        return view('admin.products.index');
    })->name('product-edit');

    // product-view Routes
    Route::get('/product/view', function () {
        return view('admin.products.view');
    })->name('product-view');

    // roles Routes
    Route::get('/roles_design', function () {
        return view('admin.roles&permissions.roles');
    });

    // permissions Routes
    Route::get('/permissions_design', function () {
        return view('admin.roles&permissions.permissions');
    });

    // discount-decleare Routes
    Route::get('/discount-decleare', function () {
        return view('admin.discount-decleare.index');
    })->name('discount-decleare');

    // DMS-01:Assign Product to Sales Man
    Route::get('/assign-product-to-sales-man', function () {
        return view('admin.assign-product-to-sales-man.index');
    })->name('product-assign');

    // DMS-02: Hand Over Product to SalesMan (Stock-OUT For Store)
    Route::get('/hand-over-product-to-sales-man', function () {
        return view('admin.hand-over-product-to-sales-man.index');
    })->name('product-handover-to-salesman');


    // DMS-03: Update Sales Order Status 
    Route::get('/update-sales-status', function () {
        return view('admin.update-sales-status.index');
    })->name('');

    // DMS-03: Update Sales Order Status 
    Route::get('/cash-collection', function () {
        return view('admin.cash-collection.index');
    })->name('');

    // DMS-03: Update Sales Order Status 
    Route::get('/sells-return', function () {
        return view('admin.sells-return.index');
    })->name('');

    // DMS-03: Update Sales Order Status 
    Route::get('/payment-to-seller', function () {
        return view('admin.payment-to-seller.index');
    })->name('');

    // DMS-03: Update Sales Order Status 
    // Route::get('/purchase-return', function () {
    //     return view('admin.purchase-return.index');
    // })->name('');

    Route::get('/importcsv', [ImportCsv::class, 'index']);
    Route::post('/importcsvupload', [ImportCsv::class, 'upload_csv_file'])->name('uploadcsv');

    Route::get('/order', [OrderShipedController::class, 'OrderList'])->name('order.list');
    Route::post('/order/{orderId}', [OrderShipedController::class, 'sendOrderEmail'])->name('order.status');

    Route::resource('/custom-pages', PageController::class);

    Route::get('/custom-pages/{slug}', [PageController::class, 'show_custom_page']);

    Route::resource('/expenses', ExpenseController::class);
    Route::resource('/brands', BrandController::class);
    Route::resource('/uoms', UomController::class);
    Route::resource('/colors', ColorController::class);
    Route::resource('/sizes', SizeController::class);
    Route::resource('/products', ItemInfoController::class);
    Route::get('/products/set-price/{id}', [ItemInfoController::class, 'findSetPrice'])->name('setPrice');
    Route::post('/products/set-price-declear', [ItemInfoController::class, 'setPrice'])->name('setPriceDeclear');

    Route::resource('/itemsStoreMapping', ItemStoreMappingController::class);

    Route::get('item-store', [itemStoreController::class, 'index'])->name('item-store.index');
    Route::get('item-store/{id}', [itemStoreController::class, 'show'])->name('item-store.show');

    Route::resource('/sales', SellController::class);
    Route::get('/newsales', [SellController::class, 'newsale'])->name('newsale');
    Route::post('/newsales/getItemByBarcode', [SellController::class, 'getItem'])->name('newsaleitem');
    Route::post('/newsales/getItemByBarcodeService', [ServiceSellController::class, 'getItem'])->name('newsaleitemService');
    Route::get('/newsales/sales-invoice', [SellController::class, 'salesInvoice'])->name('salesInvoice');
    Route::get('/newsales/sales-print-Pos-Invoice/{id}', [SellController::class, 'printPosInvoice'])->name('printPosInvoice');
    Route::get('/newsales/service-sales-print-Invoice/{id}', [ServiceSellController::class, 'printPosInvoice'])->name('printServiceInvoice');

    Route::resource('/service-sales', ServiceSellController::class);
    Route::post('/service-sales/item-add-ajax', [ServiceSellController::class, 'ajax_product_add'])->name('saleItemAdd');

    Route::resource('/product/barcode', BarcodeController::class);
    Route::get('/generate-pdf', [BarcodeController::class, 'generatePDF'])->name('barcode.generate-pdf');

    Route::get('/BarcodePdf', [BarcodeController::class, 'BarcodePdf'])->name('BarcodePdf');

    Route::resource('/customers', CustomerController::class);

    Route::get('/loadProduct', [ItemInfoController::class, 'loadProduct'])->name('loadProduct');

    Route::get('/get-Product/{productId}', [ItemInfoController::class, 'getProduct']);

    Route::get('/load-categories', [GetAllModuleDataConntroller::class, 'loadCategories'])->name('loadCategories');
    Route::get('/load-sizes', [GetAllModuleDataConntroller::class, 'loadSizes'])->name('loadSizes');
    Route::get('/load-colors', [GetAllModuleDataConntroller::class, 'loadUnit'])->name('loadColor');
    // Route::get('/load-colors', [GetAllModuleDataConntroller::class, 'loadUnit'])->name('loadUnit');
    Route::get('/load-brands', [GetAllModuleDataConntroller::class, 'loadBrand'])->name('loadBrand');

    Route::get('/load-subcategories/{categoryId}', [GetAllModuleDataConntroller::class, 'loadSubcategories']);
    Route::get('/load-childcategories/{subcategoryId}', [GetAllModuleDataConntroller::class, 'loadChildrenCategories']);

    Route::get('/load-childcategories/{parentId}', [CategoryController::class, 'loadChildrenCategories']);
    Route::get('/subcategories/{parentId}', [CategoryController::class, 'loadChildrenCategories']);

    // Route::resource('/customers', CustomerController::class);
    Route::resource('/suppliers', SupplierController::class);
    Route::resource('/employees', EmployeeController::class);
    Route::resource('/stores', StoreController::class);

    Route::get('/getDivisions', [AddressFilterController::class, 'getDivisions'])->name('getDivisions');
    Route::get('/getDistricts', [AddressFilterController::class, 'getDistricts'])->name('getDistricts');
    Route::get('/getAreas', [AddressFilterController::class, 'getAreas'])->name('getAreas');
    Route::get('/getThana', [AddressFilterController::class, 'getThana'])->name('getThana');
    Route::resource('/bankInfo', BankInfoController::class);

    Route::resource('/warrantys', WarrantyController::class);
    Route::get('/get-items/{sellsId}', [WarrantyController::class, 'getItems']);

    Route::get('admin/warrantys/{warranty}/print', [WarrantyController::class, 'GennneratePdf'])->name('warrantys.print');

    Route::resource('/money-lending', MoneyLendingController::class);

    Route::resource('/daily-expenses', DailyExpensesController::class);
    Route::resource('/purchase-orders', PurchaseOrdersController::class);
    Route::resource('/purchase-return', PurchaseReturnController::class);
    Route::resource('/sales-return', SaleReturnController::class);
    Route::resource('/opening-balance', OpeningBalanceController::class);

    // report
    //transactions-detailed-by-customer
    Route::get('/transactions-detailed-by-customer', [CustomerTrasactionDetails::class, 'index'])->name('transdetailsbycustomer.index');
    Route::post('/transactions-detailed-by-customer-find', [CustomerTrasactionDetails::class, 'find'])->name('transdetailsbycustomer.find');
    Route::get('/transactions-detailed-by-customer-find-report', [CustomerTrasactionDetails::class, 'transPdf'])->name('transdetailsbycustomer.report.pdf');

    //transactions-detailed-by-supplier
    Route::get('/transactions-detailed-by-supplier', [SupplierTrasactionDetails::class, 'index'])->name('transdetailsbysupplier.index');
    Route::post('/transactions-detailed-by-supplier-find', [SupplierTrasactionDetails::class, 'find'])->name('transdetailsbysupplier.find');
    Route::get('/transactions-detailed-by-supplier-find-report', [SupplierTrasactionDetails::class, 'transPdf'])->name('transdetailsbysupplier.report.pdf');

    //mothlyProfitLoss
    Route::get('/mothlyProfitLoss', [MothlyProfitLoss::class, 'index'])->name('mothlyProfitLoss.index');
    Route::post('/mothlyProfitLoss-find', [MothlyProfitLoss::class, 'find'])->name('mothlyProfitLoss.find');
    Route::get('/mothlyProfitLoss-find-report', [MothlyProfitLoss::class, 'transPdf'])->name('mothlyProfitLoss.report.pdf');

    //moneyLending
    Route::get('/moneyLending', [MoneyLendingCotroller::class, 'index'])->name('moneyLending.index');
    Route::post('/moneyLending-find', [MoneyLendingCotroller::class, 'find'])->name('moneyLending.find');
    Route::get('/moneyLending-find-report', [MoneyLendingCotroller::class, 'transPdf'])->name('moneyLending.report.pdf');

    Route::resource('roles', RolesController::class);
    Route::resource('users', UsersController::class);
    Route::resource('admins', AdminsController::class);
    Route::resource('permissions', PermissionsController::class);

    Route::get('/clear', [ClearCache::class, 'index'])->name('clear-cache');

    // Logout route
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Route::get('user/register', [UserController::class, 'showRegistrationForm'])->name('register.form');
    // Route::post('user/register', [UserController::class, 'register'])->name('register');


    // reports 
    Route::get('report/sells-ledger', [SellsLedgerController::class, 'index'])->name('reports.sells.ledger');
    Route::get('report/purchase-ledger', [PurchaseLedgerController::class, 'index'])->name('reports.purchase.ledger');
    Route::get('report/expense', [ExpenseControllerReport::class, 'index'])->name('reports.expense');
    Route::get('report/stock-ledger', [StockLedgerController::class, 'index'])->name('reports.stock.ledger');

});

Route::get('process', [DataController::class, 'processLargeData'])->name('data-process-start');

Route::get('/create-order', [NewOrderPlacedController::class, 'store']);

// Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'web']], function () {

// });


///register

// Route::get('user/register', [UserController::class, 'showRegistrationForm'])->name('register.form');
// Route::post('user/register', [UserController::class, 'register'])->name('register');


// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
// Route::post('/login', [LoginController::class, 'login'])->name('login');
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/autoload', function () {
    // Call the route:clear command
    Artisan::call('route:clear');

    // Call the permissions:insert-route-permissions command
    Artisan::call('permissions:insert-route-permissions');

    // Optionally, you can return a response indicating success
    return response()->json(['message' => 'Autoload files and route cache have been reloaded successfully']);
})->name('autoload');
