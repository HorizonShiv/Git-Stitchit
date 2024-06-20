<?php

use App\Http\Controllers\apps\IssueManageController;
use App\Http\Controllers\Auth\LoginRegisterController;

use App\Http\Middleware\CheckStatus;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\Crm;

// All App Controller
use App\Http\Controllers\apps\CompanyAdd;
use App\Http\Controllers\apps\CompanyList;
use App\Http\Controllers\apps\EcommerceSettingsDetails;
use App\Http\Controllers\apps\SalesOrder;
use App\Http\Controllers\apps\OrderPlanning;
use App\Http\Controllers\apps\Master;
use App\Http\Controllers\apps\InvoiceList;
use App\Http\Controllers\apps\POManage;
use App\Http\Controllers\apps\GRNManage;
use App\Http\Controllers\apps\QcManage;
use App\Http\Controllers\apps\InvoicePreview;
use App\Http\Controllers\apps\InvoicePrint;
use App\Http\Controllers\apps\InvoiceEdit;
use App\Http\Controllers\apps\InvoiceAdd;
use App\Http\Controllers\apps\UserList;
use App\Http\Controllers\apps\InventoryController;
use App\Http\Controllers\apps\UserViewAccount;
use App\Http\Controllers\apps\ProductionController;
use App\Http\Controllers\apps\OrderJobCardController;

// All Pages Controller
use App\Http\Controllers\pages\UserProfile;
use App\Http\Controllers\pages\UserTeams;
use App\Http\Controllers\pages\UserProjects;
use App\Http\Controllers\pages\UserConnections;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsSecurity;
use App\Http\Controllers\pages\AccountSettingsBilling;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\Faq;
use App\Http\Controllers\pages\Pricing as PagesPricing;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\pages\MiscComingSoon;
use App\Http\Controllers\pages\MiscNotAuthorized;

// All Authentications Controller
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\LoginCover;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\RegisterCover;
use App\Http\Controllers\authentications\RegisterMultiSteps;
use App\Http\Controllers\authentications\VerifyEmailBasic;
use App\Http\Controllers\authentications\VerifyEmailCover;
use App\Http\Controllers\authentications\ResetPasswordBasic;
use App\Http\Controllers\authentications\ResetPasswordCover;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\authentications\ForgotPasswordCover;
use App\Http\Controllers\authentications\TwoStepsBasic;
use App\Http\Controllers\authentications\TwoStepsCover;

// All Master Controller
use App\Http\Controllers\masters\SeasonController;
use App\Http\Controllers\masters\FitController;
use App\Http\Controllers\masters\BrandMasterController;
use App\Http\Controllers\masters\ProcessMasterController;
use App\Http\Controllers\masters\DepartmentController;
use App\Http\Controllers\masters\CustomerMasterController;
use App\Http\Controllers\masters\StyleCategoryController;
use App\Http\Controllers\masters\ItemCategoryController;
use App\Http\Controllers\masters\ParameterMasterController;
use App\Http\Controllers\masters\ItemMaster;
use App\Http\Controllers\masters\DemographicController;
use App\Http\Controllers\masters\StyleMasterController;
use App\Http\Controllers\masters\WareHouseController;



date_default_timezone_set('Asia/Kolkata');
Route::get('/refresh', function () {
  Artisan::call('key:generate');
  Artisan::call('cache:clear');
  Artisan::call('route:clear');
  Artisan::call('view:clear');
  Artisan::call('config:clear');
  Artisan::call('optimize:clear');
  return 'Refresh Done';
});
Route::controller(LoginRegisterController::class)->group(function () {
  Route::get('/register', 'register')->name('register');
  Route::post('/store', 'store')->name('store');
  // Route::get('/login', 'login')->name('auth-login-basic');
  Route::post('/authenticate', 'authenticate')->name('authenticate');
  Route::post('/authenticateWithEmail', 'authenticateWithEmail')->name('authenticateWithEmail');
  Route::get('/resendOTP', 'resendOTP')->name('resendOTP');
  Route::post('/verifyOtp', 'verifyOtp')->name('verifyOtp');
  Route::post('/logout', 'logout')->name('logout');
});

Route::get('/down', function () {
  Artisan::call('down');
  return 'Application is now in maintenance mode.';
});

Route::get('/up', function () {
  Artisan::call('up');
  return 'Application is now live.';
});



Route::controller(\App\Http\Controllers\apps\POManage::class)->group(function () {
  Route::post('/getDeniMaxPo', 'getDeniMaxPo')->name('getDeniMaxPo');
});

Route::controller(\App\Http\Controllers\apps\GRNManage::class)->group(function () {
  Route::get('/getGRNQty', 'getGRNQty')->name('getGRNQty');
});


// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/login-cover', [LoginCover::class, 'index'])->name('auth-login-cover');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/register-cover', [RegisterCover::class, 'index'])->name('auth-register-cover');
Route::get('/auth/register-multisteps', [RegisterMultiSteps::class, 'index'])->name('auth-register-multisteps');
Route::post('/auth/auth-register-store', [RegisterMultiSteps::class, 'store'])->name('auth-register-store');
Route::get('/auth/verify-email-basic', [VerifyEmailBasic::class, 'index'])->name('auth-verify-email-basic');
Route::get('/auth/verify-email-cover', [VerifyEmailCover::class, 'index'])->name('auth-verify-email-cover');
Route::get('/auth/reset-password-basic', [ResetPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::get('/auth/reset-password-cover', [ResetPasswordCover::class, 'index'])->name('auth-reset-password-cover');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::get('/auth/forgot-password-cover', [ForgotPasswordCover::class, 'index'])->name('auth-forgot-password-cover');
Route::get('/auth/two-steps-basic', [TwoStepsBasic::class, 'index'])->name('auth-two-steps-basic');
Route::get('/auth/two-steps-cover', [TwoStepsCover::class, 'index'])->name('auth-two-steps-cover');

// Main Page Route
Route::get('/', function () {
  if (Auth::check()) {
    return view('content.dashboard.dashboards-analytics');
  }
  $pageConfigs = ['myLayout' => 'blank'];
  return view('content.authentications.auth-login-cover', ['pageConfigs' => $pageConfigs]);;
});
Route::middleware([CheckStatus::class])->group(function () {
  Route::get('/home', [Analytics::class, 'index'])->name('dashboard-analytics');
  Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard-analytics');
  Route::get('/dashboard/crm', [Crm::class, 'index'])->name('dashboard-crm');

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  ///
  /// Software URLS
  ///
  ///

  // Invoice Routes
  Route::post('/app/invoice/invoiceExcelExport', [InvoiceList::class, 'invoiceExcelExport'])->name('invoiceExcelExport');
  Route::post('/app/vendor/details', [InvoiceList::class, 'getVendorDetails'])->name('getVendorDetails');
  Route::post('/app/company/details', [InvoiceList::class, 'getCompanyDetails'])->name('getCompanyDetails');
  Route::post('/app/company/shipping-details', [InvoiceList::class, 'getCompanyShippingDetails'])->name('getCompanyShippingDetails');
  Route::post('/app/company/vendor-shpping', [InvoiceList::class, 'getVendorShippingDetails'])->name('getVendorShippingDetails');
  Route::post('getShippingAddresses', [InvoiceList::class, 'getShippingAddresses'])->name('getShippingAddresses');
  Route::get('/app/invoice/preview/{id}', [InvoicePreview::class, 'index'])->name('app-invoice-preview');
  Route::get('/app/invoice/print/{id}', [InvoicePrint::class, 'index'])->name('app-invoice-print');
  Route::get('/app/invoice/edit', [InvoiceEdit::class, 'index'])->name('app-invoice-edit');
  Route::get('/app/invoice/list', [InvoiceList::class, 'index'])->name('app-invoice-list');
  Route::post('/app/invoice/list/details', [InvoiceList::class, 'listingInvoice'])->name('listingInvoice');
  Route::get('/app/invoice/add', [InvoiceAdd::class, 'index'])->name('app-invoice-add');
  Route::get('/app/invoice/item/add', [InvoiceAdd::class, 'itemAdd'])->name('app-invoice-with-item-add');
  Route::post('/app/invoice/store', [InvoiceList::class, 'store'])->name('app-invoice-store');
  Route::post('/app/invoice/item/item-store', [InvoiceAdd::class, 'itemStore'])->name('app-invoice-with-item-store');
  Route::post('/app/invoice/details', [InvoiceList::class, 'getInvoiceDetails'])->name('getInvoiceDetails');
  Route::post('/app/invoice/viewInvoiceQuery', [InvoiceList::class, 'viewInvoiceQuery'])->name('viewInvoiceQuery');
  Route::post('/app/invoice/storeInvoiceQuery', [InvoiceList::class, 'storeInvoiceQuery'])->name('storeInvoiceQuery');
  Route::post('/storeInvoiceDetails', [InvoiceList::class, 'storeInvoiceDetails'])->name('storeInvoiceDetails');
  Route::post('/invoiceDelete', [InvoiceList::class, 'invoiceDelete'])->name('invoiceDelete');
  Route::post('/app/invoice/invoiceApprove', [InvoiceList::class, 'invoiceApprove'])->name('invoiceApprove');

  Route::get('/app/settings/details', [EcommerceSettingsDetails::class, 'index'])->name('app-ecommerce-settings-details');
  Route::post('/app/settings/settingFormSubmit', [EcommerceSettingsDetails::class, 'settingFormSubmit'])->name('settingFormSubmit');
  Route::post('/app/settings/setSettingAutoNumber', [EcommerceSettingsDetails::class, 'setSettingAutoNumber'])->name('setSettingAutoNumber');


  // PO Manage Routes
  Route::get('/app/po/list', [POManage::class, 'index'])->name('app-po-list');
  Route::get('/app/po/add', [POManage::class, 'poAddView'])->name('app-po-add');
  Route::get('/app/po/requestlist', [POManage::class, 'requestlist'])->name('app-po-requestlist');
  Route::post('/app/po/store', [POManage::class, 'poAddStore'])->name('poAddStore');
  Route::post('/app/po/mail', [POManage::class, 'viewPOMail'])->name('viewPOMail');
  Route::get('/app/po/preview/{id}', [POManage::class, 'show'])->name('app-po-preview');
  Route::get('/app/po/print/{id}', [POManage::class, 'printPO'])->name('app-po-print');
  Route::get('/app/po/edit/{id}', [POManage::class, 'edit'])->name('app-po-edit');
  Route::put('/app/po/update/{id}', [POManage::class, 'update'])->name('app-po-update');
  Route::post('/app/po/poApprove', [POManage::class, 'poApprove'])->name('poApprove');
  Route::get('app/po/invoice/list', [POManage::class, 'indexWithInvoice'])->name('app-po-invoice-list');
  Route::post('app/po/invoice/view', [InvoiceAdd::class, 'grnInvoiceView'])->name('grnInvoiceView');
  Route::get('app/po/invoice/view', [POManage::class, 'indexWithInvoice']);
  Route::post('/poDelete', [POManage::class, 'poDelete'])->name('poDelete');
  Route::post('/app/po/filter', [POManage::class, 'poListing'])->name('app-po-filter');

  //GRN Manage Routes
  Route::get('/app/grn/list', [GRNManage::class, 'index'])->name('app-grn-list');
  Route::post('/app/grn/filter', [GRNManage::class, 'grnListing'])->name('app-grn-filter');
  Route::get('/app/grn/add', [GRNManage::class, 'grnAddView'])->name('app-grn-add');
  Route::post('/app/grn/store', [GRNManage::class, 'grnAddStore'])->name('grnAddStore');
  Route::post('/app/grn/getPODetailForGRN', [GRNManage::class, 'getPODetailForGRN'])->name('getPODetailForGRN');
  Route::post('/getGRNQtyByOrderInward', [GRNManage::class, 'getGRNQtyByOrderInward'])->name('getGRNQtyByOrderInward');
  Route::post('/grnRollback', [GRNManage::class, 'grnRollback'])->name('grnRollback');


  // QC Manage Routes
  Route::get('/app/qc/list', [QcManage::class, 'index'])->name('app-qc-list');
  Route::get('/app/qc/add', [QcManage::class, 'qcAddView'])->name('app-qc-add');
  Route::post('/app/qc/store', [QcManage::class, 'qcAddStore'])->name('qcAddStore');
  Route::post('/app/qc/getPODetailForQC', [QcManage::class, 'getPODetailForQC'])->name('getPODetailForQC');
  Route::get('app/qc/invoice/list', [QcManage::class, 'indexWithInvoice'])->name('app-qc-invoice-list');

  // Invetory Routes
  Route::get('/inventory/list', [InventoryController::class, 'index'])->name('inventory-list');
  Route::get('/inventory/history', [InventoryController::class, 'historyList'])->name('inventory-history');
  Route::post('/inventory/delete', [InventoryController::class, 'delete'])->name('inventory-delete');
  Route::post('/inventory/filter', [InventoryController::class, 'inventoryList'])->name('inventoryFilter');
  Route::post('/inventory/history', [InventoryController::class, 'inventoryHistory'])->name('inventoryHistory');
  // Sales order Routes
  Route::resource('/sales-order', SalesOrder::class);
  Route::post('/Sales-Style-update', [SalesOrder::class, 'update'])->name('getSalesDataUpdate');
  Route::post('/Sales-Style-Edit', [SalesOrder::class, 'getSalesDataEdit'])->name('getSalesDataEdit');
  Route::post('/Sales-Style-Data-View', [SalesOrder::class, 'getSalesParameterDataView'])->name('getSalesParameterDataView');
  Route::post('/Sales-Style-View', [SalesOrder::class, 'getSalesDataView'])->name('getSalesDataView');
  Route::post('/Sales-Style-Data', [SalesOrder::class, 'salesStyleData'])->name('StoreSalesStyleData');
  Route::post('/sales-order/item-parameter', [SalesOrder::class, 'getItemParameter'])->name('getItemParameter');
  Route::post('/sales-order/delete', [SalesOrder::class, 'delete'])->name('sales-order-delete');
  Route::get('/sales-order/edit/{id}', [SalesOrder::class, 'edit'])->name('sales-order-edit');
  Route::get('/sales-order/view/{id}', [SalesOrder::class, 'view'])->name('sales-order-view');
  Route::post('/sales-order/list', [SalesOrder::class, 'saleOrderList'])->name('sales-order-fliter');

  // Order Planning Routes
  Route::resource('order-planning', OrderPlanning::class);
  Route::get('/planning/create/{sale_id}', [OrderPlanning::class, 'create'])->name('order-planning-create');
  Route::get('/planning/create/{sale_id}/{planing_order_id}/{type}', [OrderPlanning::class, 'create'])->name('order-planning-create-with-planing-order');
  Route::post('/planning/getStyleDetails', [OrderPlanning::class, 'getStyleDetails'])->name('getPlanningStyleDetails');
  Route::post('/planning/getStyleDetailsForSample', [OrderPlanning::class, 'getStyleDetailsForSample'])->name('getSampleStyleDetails');
  Route::post('/planning/getItemDetails', [OrderPlanning::class, 'getItemDetails'])->name('getItemDetails');
  Route::post('/planning/getCategoryDetails', [OrderPlanning::class, 'getCategoryDetails'])->name('getCategoryDetails');
  Route::post('/planning/getSubCategoryDetails', [OrderPlanning::class, 'getSubCategoryDetails'])->name('getSubCategoryDetails');
  Route::post('/processDelete', [OrderPlanning::class, 'processDelete'])->name('processDelete');
  Route::post('/processEdit', [OrderPlanning::class, 'processEdit'])->name('processEdit');
  Route::post('/bomListDelete', [OrderPlanning::class, 'bomListDelete'])->name('bomListDelete');
  Route::post('/bomListEdit', [OrderPlanning::class, 'bomListEdit'])->name('bomListEdit');
  Route::post('/requestPO', [OrderPlanning::class, 'requestPO'])->name('requestPO');
  Route::get('/order-planing/pendinglist', [OrderPlanning::class, 'pendinglist'])->name('order-planing-pendinglist');
  Route::get('/order-planing/list', [OrderPlanning::class, 'list'])->name('order-planing-list');

  // Master Routes
  Route::get('/app/master/view', [Master::class, 'index'])->name('app-master-list');

  // Customer Routes
  Route::resource('/customer', CustomerMasterController::class);
  Route::get('/customer/edit/{id}', [CustomerMasterController::class, 'edit'])->name('customer-edit');
  Route::get('/customer/view/{id}', [CustomerMasterController::class, 'view'])->name('customer-view');
  Route::put('/customer/update/{id}', [CustomerMasterController::class, 'update'])->name('customer-update');
  Route::post('/customer/delete', [CustomerMasterController::class, 'delete'])->name('customer-delete');
  Route::post('/customer-shipping/delete', [CustomerMasterController::class, 'shippingDelete'])->name('customer-shipping-delete');

  // Style Category Routes
  Route::resource('/style-category', StyleCategoryController::class);
  Route::get('/style-category/edit/{id}', [StyleCategoryController::class, 'edit'])->name('style-category-edit');
  Route::put('/style-category/update/{id}', [StyleCategoryController::class, 'update'])->name('style-category-update');
  Route::post('/style-category/delete', [StyleCategoryController::class, 'delete'])->name('style-category-delete');
  Route::post('/style-subcategory/delete', [StyleCategoryController::class, 'subcategorydelete'])->name('style-subcategory-delete');

  // Parameter Routes
  Route::resource('/parameter-master', ParameterMasterController::class);
  Route::get('/parameter-master/edit/{id}', [ParameterMasterController::class, 'edit'])->name('parameter-master-edit');
  Route::put('/parameter-master/update/{id}', [ParameterMasterController::class, 'update'])->name('parameter-master-update');
  Route::post('/parameter-master/delete', [ParameterMasterController::class, 'delete'])->name('parameter-master-delete');

  // Demographic Routes
  Route::resource('demographic', DemographicController::class);
  Route::get('/demographic/edit/{id}', [DemographicController::class, 'edit'])->name('demographic-edit');
  Route::put('/demographic/update/{id}', [DemographicController::class, 'update'])->name('demographic-update');
  Route::post('/demographic/delete', [DemographicController::class, 'delete'])->name('demographic-delete');

  // Season Routes
  Route::resource('/season', SeasonController::class);
  Route::get('/season/edit/{id}', [SeasonController::class, 'edit'])->name('season-edit');
  Route::put('/season/update/{id}', [SeasonController::class, 'update'])->name('season-update');
  Route::post('/season/delete', [SeasonController::class, 'delete'])->name('season-delete');

  // Fit Routes
  Route::resource('/fit', FitController::class);
  Route::get('/fit/edit/{id}', [FitController::class, 'edit'])->name('Fit-edit');
  Route::put('/fit/update/{id}', [FitController::class, 'update'])->name('Fit-update');
  Route::post('/fit/delete', [FitController::class, 'delete'])->name('Fit-delete');

  // Brand Master Routes
  Route::resource('/brand-master', BrandMasterController::class);
  Route::get('/brand-master/edit/{id}', [BrandMasterController::class, 'edit'])->name('brand-master-edit');
  Route::put('/brand-master/update/{id}', [BrandMasterController::class, 'update'])->name('brand-master-update');
  Route::post('/brand-master/delete', [BrandMasterController::class, 'delete'])->name('brand-master-delete');

  // Process Master Routes
  Route::resource('/process-master', ProcessMasterController::class);
  Route::get('/process-master/edit/{id}', [ProcessMasterController::class, 'edit'])->name('process-master-edit');
  Route::put('/process-master/update/{id}', [ProcessMasterController::class, 'update'])->name('process-master-update');
  Route::post('/process-master/delete', [ProcessMasterController::class, 'delete'])->name('process-master-delete');

  // Item Category Routes
  Route::resource('/item-category', ItemCategoryController::class);
  Route::get('/item-category/edit/{id}', [ItemCategoryController::class, 'edit'])->name('item-category-edit');
  Route::put('/item-category/update/{id}', [ItemCategoryController::class, 'update'])->name('item-category-update');
  Route::post('/item-category/delete', [ItemCategoryController::class, 'delete'])->name('item-category-delete');
  Route::post('/item-subcategory/delete', [ItemCategoryController::class, 'subcategorydelete'])->name('item-subcategory-delete');

  // Department Routes
  Route::resource('/department', DepartmentController::class);
  Route::get('/department/edit/{id}', [DepartmentController::class, 'edit'])->name('department-edit');
  Route::put('/department/update/{id}', [DepartmentController::class, 'update'])->name('department-update');
  Route::post('/department/delete', [DepartmentController::class, 'delete'])->name('department-delete');

  // Ware House Routes
  Route::resource('/warehouse-master', WareHouseController::class);
  Route::get('/warehouse-master/edit/{id}', [WareHouseController::class, 'edit'])->name('warehouse-master-edit');
  Route::put('/warehouse-master/update/{id}', [WareHouseController::class, 'update'])->name('warehouse-master-update');
  Route::post('/warehouse-master/delete', [WareHouseController::class, 'delete'])->name('warehouse-master-delete');
  Route::post('/getJobOrderItem', [WareHouseController::class, 'getJobOrderItem'])->name('getJobOrderItem');
  Route::post('/getJobOrderItemQty', [WareHouseController::class, 'getJobOrderItemQty'])->name('getJobOrderItemQty');
  Route::post('/outward/add', [WareHouseController::class, 'outwardAdd'])->name('outward-add');
  Route::get('/app/outward', [WareHouseController::class, 'warehouseOutward'])->name('warehouse-outward');
  Route::get('/app/outward/list', [WareHouseController::class, 'warehouseOutwardList'])->name('warehouse-outward-list');
  Route::get('/app/gr-supplier', [WareHouseController::class, 'grSupplier'])->name('warehouse-gr-supplier');
  Route::get('/app/warehouse/view', [WareHouseController::class, 'warehouseView'])->name('warehouse-view');
  Route::get('/app/app-warehouse-transfer/outward', [WareHouseController::class, 'warehouseTransfer'])->name('out-warehouse-transfer');

  Route::post('/getGrnItemForWarehouse', [WareHouseController::class, 'getGrnItemForWarehouse'])->name('getGrnItemForWarehouse');
  Route::post('/gr-supplier/add', [WareHouseController::class, 'addGrToSupplier'])->name('addGrToSupplier');
  Route::post('/getGrnItemQty', [WareHouseController::class, 'getGrnItemQty'])->name('getGrnItemQty');
  Route::post('/fetchQtyInventory', [WareHouseController::class, 'fetchQtyInventory'])->name('fetchQtyInventory');
  Route::post('/addwarehouseTransfer', [WareHouseController::class, 'addwarehouseTransfer'])->name('addwarehouseTransfer');
  Route::get('/app/gr-supplier/list', [WareHouseController::class, 'grSupplierList'])->name('gr-supplier-list');
  Route::get('/app/warehouse/outward/list', [WareHouseController::class, 'warehouseTransferList'])->name('warehouse-transfer-list');

  Route::get('/app/app-warehouse-transfer/inward', [WareHouseController::class, 'warehouseInward'])->name('in-warehouse-transfer');
  Route::get('/app/warehouse/inward/list', [WareHouseController::class, 'warehouseInwardList'])->name('warehouse-inward-list');
  Route::post('/getOutwardData', [WareHouseController::class, 'getOutwardData'])->name('getOutwardData');
  Route::post('/addWareHouseInward', [WareHouseController::class, 'addWareHouseInward'])->name('addWareHouseInward');


  // Production Routes
  Route::get('/production/process', [ProductionController::class, 'process'])->name('production-process');
  Route::get('/production/pendingList', [ProductionController::class, 'pendingList'])->name('production-pendingList');
  Route::get('/production/pending-list', [ProductionController::class, 'pendinglist'])->name('pending-list');
  Route::get('/production/issue-to', [ProductionController::class, 'issueTo'])->name('issue-to');

  // Item Master Routes
  Route::resource('/item-master', ItemMaster::class);
  Route::get('/item-master/edit/{id}', [ItemMaster::class, 'edit'])->name('item-master-edit');
  Route::get('getItemSubCategories', [ItemMaster::class, 'getSubCategories'])->name('getItemSubCategories');
  Route::put('/item-master/update/{id}', [ItemMaster::class, 'update'])->name('item-master-update');
  Route::post('/item-master/delete', [ItemMaster::class, 'delete'])->name('item-master-delete');
  Route::get('/item-master/view/{id}', [ItemMaster::class, 'view'])->name('item-master-view');
  Route::post('/fetch-item-data', [ItemMaster::class, 'fetchItemData'])->name('fetchItemData');

  // Style Master Routes
  Route::resource('/style-master', StyleMasterController::class);
  Route::get('/style-master/edit/{id}', [StyleMasterController::class, 'edit'])->name('style-master-edit');
  Route::get('getStyleSubCategories', [StyleMasterController::class, 'getSubCategories'])->name('getStyleSubCategories');
  Route::put('/style-master/update/{id}', [StyleMasterController::class, 'update'])->name('style-master-update');
  Route::post('/style-master/delete', [StyleMasterController::class, 'delete'])->name('style-master-delete');
  Route::get('/style-master/view/{id}', [StyleMasterController::class, 'view'])->name('style-master-view');
  Route::post('/style/details', [StyleMasterController::class, 'getStyleDetails'])->name('getStyleDetails');
  Route::post('/sales-new-style', [StyleMasterController::class, 'addNewStyleSalesOrder'])->name('addNewStyleSalesOrder');
  Route::post('/style-master/filter', [StyleMasterController::class, 'styleMasterList'])->name('style-master-filter');
  Route::post('/style-master/image/delete', [StyleMasterController::class, 'styleImageDelete'])->name('style-image-delete');

  // Order Job Card Routes
  Route::get('/order-job-card/pendinglist', [OrderJobCardController::class, 'index'])->name('order-job-list-pendinglist');
  Route::get('/order-job-card/Report-Job-Card/{id}', [OrderJobCardController::class, 'JobCardReportPrint'])->name('JobCardReportPrint');
  Route::get('/order-job-card/list', [OrderJobCardController::class, 'list'])->name('order-job-list');
  Route::post('/order-job-card/listAjax', [OrderJobCardController::class, 'listAjax'])->name('order-job-list-ajax');
  Route::resource('order-job-card', OrderJobCardController::class);
  Route::get('/order-job-card/create/{planing_order_id}', [OrderJobCardController::class, 'create'])->name('order-job-card.create');
  Route::get('/order-job-card/saleOrder/create', [OrderJobCardController::class, 'createBySaleOrder'])->name('createBySaleOrder');
  Route::get('/order-job-card/edit/{id}', [OrderJobCardController::class, 'edit'])->name('order-job-card.edit');
  Route::put('/order-job-card/update/{id}', [OrderJobCardController::class, 'update'])->name('order-job-card.update');
  Route::get('/order-job-card/view/{id}', [OrderJobCardController::class, 'view'])->name('order-job-card.view');
  Route::get('/order-job-card/sample/create', [OrderJobCardController::class, 'sampleCreate'])->name('order-job-card.sample.create');
  Route::post('/order-job-card/sampleStore', [OrderJobCardController::class, 'sampleStore'])->name('order-job-card.sampleStore');
  Route::get('/order-job-card/sample/edit/{id}', [OrderJobCardController::class, 'sampleEdit'])->name('order-job-card.sample.edit');
  Route::get('/order-job-card/sample/view/{id}', [OrderJobCardController::class, 'sampleView'])->name('order-job-card.sample.view');
  Route::put('/order-job-card/sampleUpdate/{id}', [OrderJobCardController::class, 'sampleUpdate'])->name('order-job-card.sampleUpdate');
  Route::post('/order-job-card/getSaleOrderDetails', [OrderJobCardController::class, 'getSaleOrderDetails'])->name('getSaleOrderDetails');
  Route::post('/order-job-card/storeBySaleOrder', [OrderJobCardController::class, 'storeBySaleOrder'])->name('storeBySaleOrder');

  // setVendorType
  Route::post('/app/user/vendor-type', [UserList::class, 'setVendorType'])->name('setVendorType');
  Route::get('/app/user/list', [UserList::class, 'index'])->name('app-user-list');
  Route::get('/app/user/add', [UserList::class, 'UserCreate'])->name('app-user-add');
  Route::get('/app/vendor/list', [UserList::class, 'vendorIndex'])->name('app-vendor-list');
  Route::put('/app/user/update/{id}', [UserList::class, 'update'])->name('app-user-update');
  Route::post('/app/user/store', [UserList::class, 'UserStore'])->name('app-user-store');
  Route::get('/app/user/view/account', [UserViewAccount::class, 'index'])->name('app-user-view-account');
  Route::get('/app/user/view/{id}', [UserViewAccount::class, 'show'])->name('app-user-view');
  Route::post('/app/user/vendorApprove', [UserList::class, 'vendorApprove'])->name('vendorApprove');
  Route::put('/app/company/update/{id}', [CompanyList::class, 'update'])->name('app-company-update');
  Route::post('/viewModelUserEdit', [UserList::class, 'viewModelUserEdit'])->name('viewModelUserEdit');
  Route::post('/storeModelUserEdit', [UserList::class, 'storeModelUserEdit'])->name('storeModelUserEdit');
  Route::get('/app/company/add', [CompanyAdd::class, 'index'])->name('app-company-add');
  Route::get('/app/company/list', [CompanyList::class, 'index'])->name('app-company-list');
  Route::post('/app/company/store', [CompanyList::class, 'store'])->name('app-company-store');
  Route::get('/app/company/view/{id}', [CompanyList::class, 'view'])->name('app-company-view');
  Route::get('/app/company/edit/{id}', [CompanyList::class, 'edit'])->name('app-company-edit');
  Route::put('/app/company/update/{id}', [CompanyList::class, 'update'])->name('app-company-update');
  Route::post('/app/company/ship-delete', [CompanyList::class, 'deleteShipAddress'])->name('app-company-ship-remove');

  // pages
  Route::get('/pages/profile-user', [UserProfile::class, 'index'])->name('pages-profile-user');
  Route::get('/pages/profile-teams', [UserTeams::class, 'index'])->name('pages-profile-teams');
  Route::get('/pages/profile-projects', [UserProjects::class, 'index'])->name('pages-profile-projects');
  Route::get('/pages/profile-connections', [UserConnections::class, 'index'])->name('pages-profile-connections');
  Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
  Route::get('/pages/account-settings-security', [AccountSettingsSecurity::class, 'index'])->name('pages-account-settings-security');
  Route::get('/pages/account-settings-billing', [AccountSettingsBilling::class, 'index'])->name('pages-account-settings-billing');
  Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
  Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
  Route::get('/pages/faq', [Faq::class, 'index'])->name('pages-faq');
  Route::get('/pages/pricing', [PagesPricing::class, 'index'])->name('pages-pricing');
  Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
  Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
  Route::get('/pages/misc-comingsoon', [MiscComingSoon::class, 'index'])->name('pages-misc-comingsoon');
  Route::get('/pages/misc-not-authorized', [MiscNotAuthorized::class, 'index'])->name('pages-misc-not-authorized');

  // Production Routes
  Route::get('/production/{id}', [ProductionController::class, 'index'])->name('production');
  Route::get('/production/pending-list/{d_id}', [ProductionController::class, 'pendingList'])->name('pending-list-wise');
  Route::get('/production/dashboard/{d_id}', [ProductionController::class, 'departmentDashboard'])->name('department-dashboard-wise');
  Route::get('/production/issue-to/{d_id}/{j_id}', [ProductionController::class, 'issueTo'])->name('issue-to');
  Route::get('/production/issue-to-on-floor/{d_id}/{j_id}/{imh_id}', [ProductionController::class, 'issueTo'])->name('issue-to-on-floor');
  Route::get('/production/process', [ProductionController::class, 'process'])->name('production-process');
  Route::get('/production/pendingList', [ProductionController::class, 'pendingList'])->name('production-pendingList');
  Route::get('/production/pending-list', [ProductionController::class, 'pendinglist'])->name('pending-list');
  Route::get('/production/pending-history/{d_id}', [ProductionController::class, 'processHistory'])->name('processHistory');
  Route::post('/production/pendingListAjax', [ProductionController::class, 'pendingListAjax'])->name('pendingListAjax');
  Route::post('/production/processHistoryAjax', [ProductionController::class, 'processHistoryAjax'])->name('processHistoryAjax');

  Route::get('/packaging/add', [ProductionController::class, 'packagingAdd'])->name('packagingAdd');
  Route::get('/packaging/list', [ProductionController::class, 'packagingList'])->name('packagingList');
  Route::post('/getStylePackaging', [ProductionController::class, 'getStylePackaging'])->name('getStylePackaging');
  Route::post('/getColorPackaging', [ProductionController::class, 'getColorPackaging'])->name('getColorPackaging');
  Route::post('/getSizeWiseDataPackaging', [ProductionController::class, 'getSizeWiseDataPackaging'])->name('getSizeWiseDataPackaging');
  // Route::get('/packagingPrint', [ProductionController::class, 'packagingPrint'])->name('packagingPrint');

  //Admin issue manage
  Route::resource('issue', IssueManageController::class);
  Route::post('issue/viewIssuePopup', [IssueManageController::class, 'viewIssuePopup'])->name('issue.viewIssuePopup');
  Route::get('issue/index/view/{id}', [IssueManageController::class, 'allIndex'])->name('issue.all-index');
  Route::post('issue/index/listing', [IssueManageController::class, 'allListingIssue'])->name('issue.all-listing');
  Route::post('issue/viewIssueHistoryPopup', [IssueManageController::class, 'viewIssueHistoryPopup'])->name('issue.viewIssueHistoryPopup');

  Route::post('issue/issueToStore', [ProductionController::class, 'issueToStore'])->name('issue.issueToStore');
  Route::get('issue/history/view/{id}', [ProductionController::class, 'processHistoryView'])->name('processHistoryView');

  Route::post('issue/getInwardById', 'IssueManageController@getInwardById')->name('issue.getInwardById');
  Route::delete('issueDelete/{id}', 'IssueManageController@destroy')->middleware(['role:Manager|Super Admin|Washing|Creation|Account Assistant|Account Manager|Process Inward|Account']);
  Route::post('issue/getInwardDetails', 'IssueManageController@getInwardDetails')->name('issue.getInwardDetails');
  Route::post('issue/listing', 'IssueManageController@listingIssue')->name('issue.listing');
  Route::post('issue/viewIssueReceivePopup', 'IssueManageController@viewIssueReceivePopup')->name('issue.viewIssueReceivePopup');
  Route::post('issue/viewIssuePopupForTransfer', 'IssueManageController@viewIssuePopupForTransfer')->name('issue.viewIssuePopupForTransfer');
  Route::post('issue/receive', 'IssueManageController@receive')->name('issue.receive');
  Route::post('issue/packingReceive', 'IssueManageController@packingReceive')->name('issue.packingReceive');
  Route::post('issue/changeDepartment', 'IssueManageController@changeDepartment')->name('issue.changeDepartment');
  Route::post('issue/scanCompleteDone', 'IssueManageController@scanCompleteDone')->name('issue.scanCompleteDone');
  Route::get('issue/jobCard/{id}/{type}/{uid}', 'IssueManageController@jobCardManage')->name('issue.jobCardManage');


  Route::get('all-scan-issue-index', 'IssueManageController@allScanIndex')->name('issue.all-scan-index');
  Route::post('all-scan-issue-listing', 'IssueManageController@allScanListingIssue')->name('issue.all-scan-listing');
  Route::post('all-scan-issue-listing-single', 'IssueManageController@allScanListingIssueSingleRow')->name('issue.all-scan-listing-single');
  Route::get('user-operation-scan-index', 'IssueManageController@userOperationScanIndex')->name('issue.user-operation-scan-index');
  Route::post('user-operation-scan-listing', 'IssueManageController@userOperationScanListing')->name('issue.user-operation-scan-list');

  Route::get('withoutScanReceive', 'IssueManageController@withoutScanCreate')->name('issue.withoutScanReceive');
  Route::post('issue/storeSelectedUser', 'IssueManageController@storeSelectedUser')->name('issue.storeSelectedUser');


  // Production- Process -Department Pending List:
  //  Route::get('/production/pending-list/', function () {
  //    return view('content.production.pendinglist');
  //  })->name('pending-list');

  // Production History :

  // Issue to Department


  Route::get('/production/process-transfer-department-print-preview/view', function () {
    return view('content.production.process-transfer.process-transfer-department-print');
  })->name('process-transfer-departmentPrintPreview');


  Route::get('/production/process-transfer-department-print/view', function () {
    return view('content.production.process-transfer.process-transfer-department-print');
  })->name('process-transfer-departmentPrint');


  Route::get('/production/process-transfer-jobCenter-print/view', function () {
    return view('content.production.process-transfer.process-transfer-jobCenter-print');
  })->name('process-transfer-print');

  Route::get('/production/process-transfer-jobCenter-printPreview/view', function () {
    return view('content.production.process-transfer.process-transfer-jobCenter-printPreview');
  })->name('process-transfer-preview');
});
