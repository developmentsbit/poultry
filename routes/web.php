<?php

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuActionController;
use App\Http\Controllers\UserMenuActionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\SoftwaresettingControllers;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MeasurementSubUnit;
use App\Http\Controllers\WebsiteInfoController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\CustomerPaymentController;
use App\Http\Controllers\IncomeExpenseTitleController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BankTransactionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SalarySetupController;
use App\Http\Controllers\SalaryDeposit;
use App\Http\Controllers\SalaryWithdrawController;
use App\Http\Controllers\InvestorRegistration;
use App\Http\Controllers\LoanRecivedController;
use App\Http\Controllers\LoanProvideController;
use App\Http\Controllers\InternalLoanRegister;
use App\Http\Controllers\InternalLoanRecived;
use App\Http\Controllers\InternalLoanProvide;
use App\Http\Controllers\BankTransController;
use App\Http\Controllers\PurchaseWithSales;
use App\Http\Controllers\IncomeExpenseReportController;
use App\Http\Controllers\CashCloseController;
use App\Http\Controllers\CashCloseReportController;
use App\Http\Controllers\ProductBarcode;
use App\Http\Controllers\LoanReportController;
use App\Http\Controllers\InternalLoanReport;
use App\Http\Controllers\CustomerTransController;
use App\Http\Controllers\SupplierTransReport;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\SalesReturnController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetCostController;
use App\Http\Controllers\AssetDepreciationController;
use App\Http\Controllers\DamageProductController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\SalesProfitController;
use App\Http\Controllers\ProfitReportController;
use App\Http\Controllers\AssetInvestController;
use App\Http\Controllers\AssetReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\FinancialStatementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',function(){
    return redirect('/login');
});


// Route::get('/pass',function(){
//     $pass = Hash::make('admin@ali123');

//     return $pass;
// });




Auth::routes();


Route::get('/member/login', [LoginController::class, 'showMemberLoginForm'])->name('member.login-view');
Route::post('/member/login', [LoginController::class, 'memberLogin'])->name('member.login');

// member routes
// Route::get('/member', function () {
//     return redirect()->url('member/dashboard');
// });

Route::group(['middleware' => ['member'], 'prefix' => 'member'], function () {
    Route::get('/dashboard', [\App\Http\Controllers\Member\DashboardController::class, 'index'])->name('member.dashboard');
    Route::get('/profile', [\App\Http\Controllers\Member\DashboardController::class, 'profile'])->name('member.profile');
});


Route::any('lang/{lang}', function ($lang) {
    session()->put('lang', $lang);
    return redirect()->back();
})->name('lang');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //    Route::get('user/permission/{id}', 'UserController@permission')->name('user.permission');
//    Route::post('user/permission-update/{id}', 'UserController@permissionUpdate')->name('user.permission_update');
//    Route::post('get_role_permission', 'RoleController@getRolePermission')->name('get_role_permission');
//    Route::get('/profile', 'UserController@profile')->name('user.profile');
    Route::post('/profile-update', [UserController::class, 'profileUpdate'])->name('user.profile-update');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.change-password');
    Route::post('/user/print', [UserController::class, 'print'])->name('user.print');
    Route::post('/user/status', [UserController::class, 'status'])->name('user.status');
    Route::get('/user/deleted-list', [UserController::class, 'deletedListIndex'])->name('user.deleted_list');
    Route::get('/user/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
    Route::delete('/user/force-delete/{id}', [UserController::class, 'forceDelete'])->name('user.force_destroy');
    Route::resource('user', UserController::class);

    Route::post('/menu/status', 'MenuController@status')->name('menu.status');
    Route::get('/menu/deleted-list', 'MenuController@deletedListIndex')->name('menu.deleted_list');
    Route::get('/menu/restore/{id}', 'MenuController@restore')->name('menu.restore');
    Route::delete('/menu/force-delete/{id}', 'MenuController@forceDelete')->name('menu.force_destroy');
    Route::post('/menu/multiple-delete', 'MenuController@multipleDelete')->name('menu.multiple_delete');
    Route::post('/menu/multiple-restore', 'MenuController@multipleRestore')->name('menu.multiple_restore');
    Route::resource('menu', MenuController::class);


    Route::post('/menu_action/status', 'MenuActionController@status')->name('menu_action.status');
    Route::get('/menu-action/deleted-list', 'MenuActionController@deletedListIndex')->name('menu_action.deleted_list');
    Route::get('/menu-action/restore/{id}', 'MenuActionController@restore')->name('menu_action.restore');
    Route::delete('/menu-action/force-delete/{id}', 'MenuActionController@forceDelete')->name('menu_action.force_destroy');
    Route::resource('menu_action', MenuActionController::class);

    Route::post('member/print', [MemberController::class, 'print'])->name('member.print');
    Route::post('member/status', [MemberController::class, 'status'])->name('member.status');
    Route::get('/member/deleted-list', [MemberController::class, 'deletedListIndex'])->name('member.deleted_list');
    Route::get('/member/restore/{id}', [MemberController::class, 'restore'])->name('member.restore');
    Route::delete('/member/force-delete/{id}', [MemberController::class, 'forceDelete'])->name('member.force_destroy');

    Route::resources([
        'aboutus' => AboutUsController::class,
        'webiste_info' => WebsiteInformation::class,
        'photo_gallery' => PhotoGallery::class,
        'services' => ServiceController::class,
        'project_cat' => ProjectCategorey::class,
        'project_info' => ProjectController::class,
        'testimonial' => TestimonialController::class,
        'member' => MemberController::class,
        'team' => TeamController::class,
        'messages' => MessageController::class,
        'vedio_gallery' => VedioGallery::class,
        'website_info' => WebsiteInfoController::class,
        'bank_transaction' => BankTransactionController::class,
        'employee' => EmployeeController::class,
    ]);

    Route::get('retrive_message/{id}', [MessageController::class, 'retrive_message']);
    Route::get('permenantMessageDelete/{id}', [MessageController::class, 'permenantMessageDelete']);


    Route::post('photoGalleryStatusChange', [PhotoGallery::class, 'photoGalleryStatusChange']);
    Route::get('retrive_photo/{id}', [PhotoGallery::class, 'retrive_photo']);
    Route::get('permenant_delete/{id}', [PhotoGallery::class, 'permenant_delete']);


    Route::get('retrive_service/{id}', [ServiceController::class, 'retrive_service']);
    Route::get('service_per_delete/{id}', [ServiceController::class, 'service_per_delete']);
    Route::post('serviceStatusChange', [ServiceController::class, 'serviceStatusChange']);

    Route::get('retrive_project_cat/{id}', [ProjectCategorey::class, 'retrive_project_cat']);
    Route::get('permenantDeleteProjectCat/{id}', [ProjectCategorey::class, 'permenantDeleteProjectCat']);
    Route::post('projectCatStatus', [ProjectCategorey::class, 'projectCatStatus']);

    Route::post('projectStatus', [ProjectController::class, 'projectStatus']);
    Route::get('retrive_project/{id}', [ProjectController::class, 'retrive_project']);
    Route::get('project_per_delete/{id}', [ProjectController::class, 'project_per_delete']);


    Route::post('testimonialStatus', [TestimonialController::class, 'testimonialStatus']);
    Route::get('retrive_testimonial/{id}', [TestimonialController::class, 'retrive_testimonial']);
    Route::get('testimonial_per_delete/{id}', [TestimonialController::class, 'testimonial_per_delete']);

    Route::post('teamMemberStatus', [TeamController::class, 'teamMemberStatus']);
    Route::get('retrive_teammember/{id}', [TeamController::class, 'retrive_teammember']);
    Route::get('temameber_per_delete/{id}', [TeamController::class, 'temameber_per_delete']);


    Route::post('vedioStatus', [VedioGallery::class, 'vedioStatus']);
    Route::get('retrive_vedio/{id}', [VedioGallery::class, 'retrive_vedio']);
    Route::get('vedio_per_delete/{id}', [VedioGallery::class, 'vedio_per_delete']);


    Route::get('menu/action/{menu_id}', [UserMenuActionController::class, 'index'])->name('user_menu_action.index');
    Route::get('menu/action/create/{menu_id}', [UserMenuActionController::class, 'create'])->name('user_menu_action.create');
    Route::post('menu/action/store/{menu_id}', [UserMenuActionController::class, 'store'])->name('user_menu_action.store');
    Route::get('menu/action/edit/{menu_id}/{id}', [UserMenuActionController::class, 'edit'])->name('user_menu_action.edit');
    Route::delete('menu/action/destroy/{menu_id}/{id}', [UserMenuActionController::class, 'destroy'])->name('user_menu_action.destroy');
    Route::post('menu/action/update/{menu_id}/{id}', [UserMenuActionController::class, 'update'])->name('user_menu_action.update');
    Route::post('user/menu/action/status', [UserMenuActionController::class, 'status'])->name('user_menu_action.status');

    Route::get('/role/{id}/permission', [RoleController::class, 'permission'])->name('role.permission');
    Route::post('/role/{id}/permission', [RoleController::class, 'permission'])->name('role.permission.store');
    Route::post('role/print', [RoleController::class, 'print'])->name('role.print');
    Route::post('role/status', [RoleController::class, 'status'])->name('role.status');
    Route::get('/role/deleted-list', [RoleController::class, 'deletedListIndex'])->name('role.deleted_list');
    Route::get('/role/restore/{id}', [RoleController::class, 'restore'])->name('role.restore');
    Route::delete('/role/force-delete/{id}', [RoleController::class, 'forceDelete'])->name('role.force_destroy');
    Route::resource('role', RoleController::class);

    Route::resource('permission', PermissionController::class);

    Route::resources([
        'company'=>SoftwaresettingControllers::class,
        'customer'=>CustomerController::class,
        'supplier'=>SupplierController::class,
        'item'=>ItemController::class,
        'category'=>CategoryController::class,
        'brand'=>BrandController::class,
        'product'=>ProductController::class,
        'measurement'=>MeasurementController::class,
        'purchase'=>PurchaseController::class,
        'measurement_subunit'=>MeasurementSubUnit::class,
        'stock'=>StockController::class,
        'sales'=>SalesController::class,
        'supplier_payment'=>SupplierPaymentController::class,
        'customer_payment'=>CustomerPaymentController::class,
        'income_expense_title'=>IncomeExpenseTitleController::class,
        'add_income'=>IncomeController::class,
        'add_expense'=>ExpenseController::class,
        'add_bank'=>BankController::class,
        'salary_setup'=>SalarySetupController::class,
        'salary_payment'=>SalaryDeposit::class,
        'salary_withdraw'=>SalaryWithdrawController::class,
        'loan_registration'=>InvestorRegistration::class,
        'loan_recived'=>LoanRecivedController::class,
        'loan_provide'=>LoanProvideController::class,
        'internal_loanregister'=>InternalLoanRegister::class,
        'internal_loan_recived'=>InternalLoanRecived::class,
        'internal_loan_provide'=>InternalLoanProvide::class,
        'bank_trans_report'=>BankTransController::class,
        'purchase_with_sales'=>PurchaseWithSales::class,
        'income_expense_report'=>IncomeExpenseReportController::class,
        'cash_close'=>CashCloseController::class,
        'cash_close_report'=>CashCloseReportController::class,
        'product_barcode'=>ProductBarcode::class,
        'loan_report'=>LoanReportController::class,
        'internal_loan_report'=>InternalLoanReport::class,
        'customer_trans_report'=>CustomerTransController::class,
        'supplier_trans_report'=>SupplierTransReport::class,
        'purchase_return' => PurchaseReturnController::class,
        'sales_return' => SalesReturnController::class,
        'asset_category' => AssetCategoryController::class,
        'asset_cost' => AssetCostController::class,
        'asset_depreciation' => AssetDepreciationController::class,
        'damage_product' => DamageProductController::class,
        'stock_report' => StockReportController::class,
        'sales_profit' => SalesProfitController::class,
        'profit_report' => ProfitReportController::class,
        'asset_invest' => AssetInvestController::class,
        'asset_report' => AssetReportController::class,
        'financial_statement' => FinancialStatementController::class,
    ]);

    Route::get('show_asset_report',[AssetReportController::class,'show_asset_report']);

    Route::get('restore_asset_invest/{id}',[AssetInvestController::class,'restore'])->name('asset_invest.restore');

    Route::get('delete_asset_invest/{id}',[AssetInvestController::class,'delete'])->name('asset_invest.delete');

    Route::get('/show_profit_report',[ProfitReportController::class,'show_profit_report']);

    Route::get('show_sales_report',[SalesProfitController::class,'show_sales_report']);

    Route::get('show_stock_report',[StockReportController::class,'show_stock_report']);

    Route::post('getOriginalQty',[DamageProductController::class,'getOriginalQty']);

    Route::get('restore_asset_depreciation/{id}',[AssetDepreciationController::class,'restore'])->name('asset_depreciation.restore');
    Route::get('delete_asset_depreciation/{id}',[AssetDepreciationController::class,'delete'])->name('asset_depreciation.delete');

    Route::get('restore_asset_category/{id}',[AssetCategoryController::class,'restore'])->name('asset_category.restore');

    Route::get('delete_asset_category/{id}',[AssetCategoryController::class,'delete'])->name('asset_category.delete');
    Route::get('asset_category_status/{id}',[AssetCategoryController::class,'status']);

    Route::get('restore_asset_cost/{id}',[AssetCostController::class,'restore'])->name('asset_cost.restore');
    Route::get('restore_asset_delete/{id}',[AssetCostController::class,'delete'])->name('asset_cost.delete');

    //

    Route::get('withdraw_cc_loan',[BankTransController::class,'withdraw_cc_loan'])->name('withdraw_cc_loan.index');
    Route::post('withDrawCCloan',[BankTransController::class,'withDrawCCloan']);
    //

    Route::get('deposit_cc_loan',[BankTransController::class,'deposit_cc_loan'])->name('deposit_cc_loan.index');
    Route::post('depositCCloan',[BankTransController::class,'depositCCloan']);

    Route::post('getLimitBalance',[BankTransController::class,'getLimitBalance']);

    Route::post('getProductPurchaseDetails',[PurchaseReturnController::class,'getProductPurchaseDetails']);
    Route::get('purchase_returns/{invoice_id}/{product_id}',[PurchaseReturnController::class,'purchase_returns']);
    Route::post('submitPurchaseReturnForm/{invoice_id}',[PurchaseReturnController::class,'submitPurchaseReturnForm']);


    Route::post('getSalesDetails',[SalesReturnController::class,'getSalesDetails']);

    Route::get('sales_returns/{invoice_no}/{product_id}',[SalesReturnController::class,'sales_returns']);
    Route::post('submitSalesReturnForm/{invoice_no}',[SalesReturnController::class,'submitSalesReturnForm']);


    Route::get('customer_advance_pay',[CustomerPaymentController::class,'customer_advance_pay'])->name('customer_advance_pay.index');
    Route::get('customer_loan',[CustomerPaymentController::class,'customer_loan'])->name('customer_loan.index');
    Route::post('customer_loan_store',[CustomerPaymentController::class,'customer_loan_store']);

    Route::get('supplier_advance_pay',[SupplierPaymentController::class,'supplier_advance_pay'])->name('supplier_advance_pay.index');
    Route::get('supplier_loan',[SupplierPaymentController::class,'supplier_loan'])->name('supplier_loan.index');
    Route::post('supplier_loan_payment',[SupplierPaymentController::class,'supplier_loan_payment']);

    Route::get('retrive_customer/{id}',[CustomerController::class,'retrive_customer']);
    Route::get('customerper_delete/{id}',[CustomerController::class,'customerper_delete']);

    Route::get('retrive_supplier/{id}',[SupplierController::class,'retrive_supplier']);
    Route::get('supplierper_delete/{id}',[SupplierController::class,'supplierper_delete']);


    Route::post('changeItemStatus',[ItemController::class,'changeItemStatus']);
    Route::get('retrive_item/{id}',[ItemController::class,'retrive_item']);
    Route::get('itemper_delete/{id}',[ItemController::class,'itemper_delete']);


    Route::post('changeCatStatus',[CategoryController::class,'changeCatStatus']);
    Route::get('retrive_category/{id}',[CategoryController::class,'retrive_category']);
    Route::get('catper_delete/{id}',[CategoryController::class,'catper_delete']);


    Route::post('changeBrandStatus',[BrandController::class,'changeBrandStatus']);

    Route::get('retrive_brand/{id}',[BrandController::class,'retrive_brand']);
    Route::get('brandper_delete/{id}',[BrandController::class,'brandper_delete']);



    Route::get('retrive_measurement/{id}',[MeasurementController::class,'retrive_measurement']);
    Route::get('measurementper_delete/{id}',[MeasurementController::class,'measurementper_delete']);


    Route::get('retrive_subunit/{id}',[MeasurementSubUnit::class,'retrive_subunit']);
    Route::get('subunit_per_delete/{id}',[MeasurementSubUnit::class,'subunit_per_delete']);

    Route::get('/getcatajax/{id}', [ProductController::class, 'getcatajax']);
    Route::post('/changeProductStatus', [ProductController::class, 'changeProductStatus']);
    Route::get('/retrive_product/{id}', [ProductController::class, 'retrive_product']);
    Route::get('/product_per_delete/{id}', [ProductController::class, 'product_per_delete']);


    Route::get('/getSupplierCompany/{supplier_id}', [PurchaseController::class, 'getSupplierCompany']);
    Route::get('/purchaseproductcart/{pdt_id}', [PurchaseController::class, 'purchaseproductcart']);
    Route::get('/purchaseproductcart2/{pdt_id}', [PurchaseController::class, 'purchaseproductcart2']);
    Route::get('/showpurchaseproductcart', [PurchaseController::class, 'showpurchaseproductcart']);
    Route::post('/qtyupdate/{id}', [PurchaseController::class, 'qtyupdate']);
    Route::post('/purchasepriceupdate/{id}', [PurchaseController::class, 'purchasepriceupdate']);
    Route::post('/purchasepricedicount/{id}', [PurchaseController::class, 'purchasepricedicount']);
    Route::post('/purchasecost/{id}', [PurchaseController::class, 'purchasecost']);
    Route::post('/salepriceupdate/{id}', [PurchaseController::class, 'salepriceupdate']);
    Route::post('/submeasurmentupdate/{id}', [PurchaseController::class, 'submeasurmentupdate']);
    Route::get('/deletepurchasecartproduct/{id}', [PurchaseController::class, 'deletepurchasecartproduct']);
    Route::post('/purchaseledger', [PurchaseController::class, 'purchaseledger']);
    Route::get('/invoicepurchase/{id}', [PurchaseController::class, 'invoice_purchase']);
    Route::get('/retrive_purchase_ledger/{id}', [PurchaseController::class, 'retrive_purchase_ledger']);
    Route::get('/deleteper_purchaseledger/{id}', [PurchaseController::class, 'deleteper_purchaseledger']);
    Route::post('/purcahseoriginalmeasurement/{id}', [PurchaseController::class, 'purcahseoriginalmeasurement']);
    Route::get('/purchase_return/{id}', [PurchaseController::class, 'purchase_return']);
    Route::get('/getcurrentpurchasereturn/{id}', [PurchaseController::class, 'getcurrentpurchasereturn']);
    Route::post('/purchaseqtyupdate/{id}', [PurchaseController::class, 'purchaseqtyupdate']);
    Route::get('/deleteCurrentReturnpurchase/{id}', [PurchaseController::class, 'deleteCurrentReturnpurchase']);
    Route::post('/purchase_return_submit', [PurchaseController::class, 'purchase_return_submit']);

    Route::get('/salesproductcart/{id}', [SalesController::class, 'salesproductcart']);
    Route::get('/salesproductcart2/{id}', [SalesController::class, 'salesproductcart2']);
    Route::get('/showsalesproductcart', [SalesController::class, 'showsalesproductcart']);
    Route::post('/qtyupdatesales/{id}', [SalesController::class, 'qtyupdatesales']);
    Route::post('/salessubmeasurmentupdate/{id}', [SalesController::class, 'salessubmeasurmentupdate']);
    Route::get('/salepriceupdatesingle/{id}', [SalesController::class, 'salepriceupdatesingle']);
    Route::post('/product_discount_amount/{id}', [SalesController::class, 'product_discount_amount']);
    Route::get('/deletesalescartproduct/{id}', [SalesController::class, 'deletesalescartproduct']);
    Route::post('/salesOriginalMeasurement/{id}', [SalesController::class, 'salesOriginalMeasurement']);
    Route::post('/salesledger', [SalesController::class, 'salesledger']);
    Route::get('/sales_invoice/{id}', [SalesController::class, 'sales_invoice']);
    Route::get('/sales_invoicea4/{id}', [SalesController::class, 'sales_invoicea4']);

    Route::post('/note_update/{id}', [SalesController::class, 'note_update']);

    Route::get('/retrive_sales_ledger/{id}', [SalesController::class, 'retrive_sales_ledger']);
    Route::get('/deleteper_salesledger/{id}', [SalesController::class, 'deleteper_salesledger']);
    Route::get('/sales_return/{id}', [SalesController::class, 'sales_return']);

    Route::post('/load_current_salesreturn', [SalesController::class, 'load_current_salesreturn']);
    Route::get('/delete_current_sales_return/{id}', [SalesController::class, 'delete_current_sales_return']);
    Route::post('/current_sales_returnqty_update/{id}', [SalesController::class, 'current_sales_returnqty_update']);
    Route::post('/sales_return_submit', [SalesController::class, 'sales_return_submit']);


    Route::get('/getsupplierInfo/{id}', [SupplierPaymentController::class, 'getsupplierInfo']);
    Route::get('/getsupplierDue/{id}', [SupplierPaymentController::class, 'getsupplierDue']);
    Route::get('/retrive_supplier_payment/{id}', [SupplierPaymentController::class, 'retrive_supplier_payment']);
    Route::get('/supplier_payment_perdelete/{id}', [SupplierPaymentController::class, 'supplier_payment_perdelete']);



    Route::get('/getcustomerInfo/{id}', [CustomerPaymentController::class, 'getcustomerInfo']);
    Route::get('/getCustomerDue/{id}', [CustomerPaymentController::class, 'getCustomerDue']);
    Route::get('/retrive_customer_payment/{id}', [CustomerPaymentController::class, 'retrive_customer_payment']);
    Route::get('/customer_payment_perdelete/{id}', [CustomerPaymentController::class, 'customer_payment_perdelete']);



    Route::get('/retrive_title/{id}', [IncomeExpenseTitleController::class, 'retrive_title']);
    Route::get('/title_per_delete/{id}', [IncomeExpenseTitleController::class, 'title_per_delete']);
    Route::post('/changetTitleStatus', [IncomeExpenseTitleController::class, 'changetTitleStatus']);



    Route::get('/retrive_income/{id}', [IncomeController::class, 'retrive_income']);
    Route::get('/income_per_delete/{id}', [IncomeController::class, 'income_per_delete']);


    Route::get('/retrive_expense/{id}', [ExpenseController::class, 'retrive_expense']);
    Route::get('/expense_per_delete/{id}', [ExpenseController::class, 'expense_per_delete']);


    Route::get('/retrive_bank/{id}', [BankController::class, 'retrive_bank']);
    Route::get('/bank_per_delete/{id}', [BankController::class, 'bank_per_delete']);


    Route::post('/gettotalamount', [BankTransactionController::class, 'gettotalamount']);
    Route::get('/retrive_bank_transaction/{id}', [BankTransactionController::class, 'retrive_bank_transaction']);
    Route::get('/bank_trans_perdelete/{id}', [BankTransactionController::class, 'bank_trans_perdelete']);


    Route::get('/retrive_employee/{id}', [EmployeeController::class, 'retrive_employee']);
    Route::get('/employee_per_delete/{id}', [EmployeeController::class, 'employee_per_delete']);


    Route::post('/employee_salary_deposit', [SalarySetupController::class, 'employee_salary_deposit']);
    Route::post('/getEmpBalance', [SalaryWithdrawController::class, 'getEmpBalance']);


    Route::get('/retrive_loan_register/{id}', [InvestorRegistration::class, 'retrive_loan_register']);
    Route::get('/delete_loan_register/{id}', [InvestorRegistration::class, 'delete_loan_register']);


    Route::get('/retrive_loan_recived/{id}', [LoanRecivedController::class, 'retrive_loan_recived']);
    Route::get('/delete_loan_recived/{id}', [LoanRecivedController::class, 'delete_loan_recived']);

    Route::post('/getloanRegisterdue_loan', [LoanProvideController::class, 'getloanRegisterBalance']);
    Route::get('/retrive_loan_provide/{id}', [LoanProvideController::class, 'retrive_loan_provide']);
    Route::get('/delete_loan_provide/{id}', [LoanProvideController::class, 'delete_loan_provide']);


    Route::get('/retrive_internalloan_register/{id}', [InternalLoanRegister::class, 'retrive_internalloan_register']);
    Route::get('/delete_internalloan_register/{id}', [InternalLoanRegister::class, 'delete_internalloan_register']);


    Route::get('/retrive_intloan_recived/{id}', [InternalLoanRecived::class, 'retrive_intloan_recived']);
    Route::get('/delete_intloan_recived/{id}', [InternalLoanRecived::class, 'delete_intloan_recived']);
    Route::post('/getintloanRegisterdue_loan', [InternalLoanRecived::class, 'getintloanRegisterdue_loan']);


    Route::get('/retrive_intloan_provide/{id}', [InternalLoanProvide::class, 'retrive_intloan_provide']);
    Route::get('/delete_intloan_provide/{id}', [InternalLoanProvide::class, 'delete_intloan_provide']);


    Route::get('/full_stock_report', [StockController::class, 'full_stock_report']);




    Route::get('customer_payment_details/{from_date}/{today_date}',[CashCloseController::class,'customer_payment_details']);
    Route::get('purchase_return_details/{from_date}/{today_date}',[CashCloseController::class,'purchase_return_details']);

    
    Route::get('/show_bank_report', [BankTransController::class, 'show_bank_report']);

    Route::get('/purchasesalesproduct/{id}', [PurchaseWithSales::class, 'purchasesalesproduct']);
    Route::get('/showcurrentpurchasesales_product', [PurchaseWithSales::class, 'showcurrentpurchasesales_product']);
    Route::post('/purchasesalesqtyupdate/{id}', [PurchaseWithSales::class, 'purchasesalesqtyupdate']);
    Route::post('/purchasesalessubunitupdate/{id}', [PurchaseWithSales::class, 'purchasesalessubunitupdate']);
    Route::post('/purchasesalesoriginalmeasurement/{id}', [PurchaseWithSales::class, 'purchasesalesoriginalmeasurement']);
    Route::get('/purchasesalespriceupdate/{id}', [PurchaseWithSales::class, 'purchasesalespriceupdate']);
    Route::post('/purchasesalespricediscount/{id}', [PurchaseWithSales::class, 'purchasesalespricediscount']);
    Route::post('/purchasesalesnoteupdate/{id}', [PurchaseWithSales::class, 'purchasesalesnoteupdate']);
    Route::get('/purchasesalespurchasepriceupdate/{id}', [PurchaseWithSales::class, 'purchasesalespurchasepriceupdate']);
    Route::get('/deletepurchase_sales_product/{id}', [PurchaseWithSales::class, 'deletepurchase_sales_product']);
    Route::post('/submitpurchasesales', [PurchaseWithSales::class, 'submitpurchasesales']);
    Route::get('/show_income_expense_report', [IncomeExpenseReportController::class, 'show_income_expense_report']);


    Route::get('/show_cash_close_report', [CashCloseReportCOntroller::class, 'show_cash_close_report']);
    Route::post('/generate_barcode', [ProductBarcode::class, 'generate_barcode']);


    Route::get('/show_loan_report', [LoanReportController::class, 'show_loan_report']);
    Route::get('/show_internal_loan_report', [InternalLoanReport::class, 'show_internal_loan_report']);
    Route::get('/show_customer_trans_report', [CustomerTransController::class, 'show_customer_trans_report']);
    Route::get('/show_supplier_trans_report', [SupplierTransReport::class, 'show_supplier_trans_report']);



});
