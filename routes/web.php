<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::fallback(function () {
    return view('error.404');
});

Auth::routes();

Route::get('/manager/dashboard','HomeController@getManagerDashboard')->name('managerdashboard');
Route::get('/users/new','userController@newUser')->name('user.new');
Route::middleware(['role:admin'])->group(function(){
	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/nas/new','nasController@newNas')->name('nas.new');
	Route::get('/nas/edit/{id}','nasController@editNas')->name('nas.edit');
	Route::get('/nas/remove/{id}','nasController@removeNas')->name('nas.remove');



	Route::get('/packages/new','packagesController@newPackage')->name('packages.new');
	Route::get('/packages/all','packagesController@allPackages')->name('packages.all');
	Route::get('/packages/edit/{id}','packagesController@editPackage')->name('packages.edit');
	Route::get('/packages/delete/{id}','packagesController@deletePackage')->name('packages.delete');
	Route::get('/packages/prices','packagesController@packagePrices')->name('package.price');


	Route::get('/services/restart/{service}','servicesController@restartService')->name('restart.service');

	Route::get('/system/logs','servicesController@getSysLogs')->name('service.logs');

	Route::get('/managers/new','managerController@newManager')->name('manager.new.get');

	Route::get('/inventory/items','inventoryController@render_items')->name('inventory.items');
	Route::get('/inventory/categories','inventoryController@render_categories')->name('inventory.categories');
	
	Route::get('/inventory/sub_categories/{category?}','inventoryController@render_sub_categories')->name('inventory.sub_categories.get');
	Route::get('/inventory/products','inventoryController@render_products')->name('inventory.products');
	Route::get('/inventory/products/new','inventoryController@render_product_new')->name('inventory.products.new');
	Route::get('/inventory/items/new','inventoryController@render_item_new')->name('inventory.item.new');
	Route::get('/inventory/item/edit/{id}','inventoryController@edit_item')->name('edit.item');
	Route::get('/inventory/product/edit/{id}','inventoryController@edit_product')->name('edit.product');
	Route::get('/inventory/items/delete/{id}','inventoryController@item_delete')->name('item.delete');
	Route::get('/inventory/product/delete/{id}','inventoryController@product_delete')->name('product.delete');
	Route::get('/inventory/suppliers','inventoryController@render_suppliers')->name('inventory.suppliers');
	Route::get('/inventory/suppliers/new','inventoryController@render_supplier_new')->name('inventory.supplier.new');
	Route::get('/inventory/supplier/edit/{id}','inventoryController@render_supplier_edit')->name('supplier.edit');
	Route::get('/inventory/supplier/delete/{id}','inventoryController@render_supplier_delete')->name('supplier.delete');
	Route::get('/inventory/vendors','inventoryController@render_vendors')->name('inventory.vendors');
	Route::get('/inventory/vendors/new','inventoryController@render_vendors_new')->name('inventory.vendors.new');
	Route::get('/inventory/vendor/delete/{id}','inventoryController@delete_vendor')->name('vendor.delete');
	Route::get('/inventory/vendor/edit/{id}','inventoryController@edit_vendor')->name('vendor.edit');

	Route::get('/tickets/new','ticketsController@newTicket')->name('tickets.new');

	Route::get('/tickets/delete/{id}','ticketsController@deleteTicket')->name('delete.ticket');
	Route::get('/settings/system','settingsController@getIndex')->name('settings.index');
	Route::get('/settings/commission','settingsController@getManagerCommission')->name('settings.managerrates');
	Route::get('/zones/new','zonesController@newZone')->name('zone.new');
	
	Route::get('/company/details','HomeController@getCompanyDetails')->name('company.details');
	Route::get('/sms/balance','HomeController@getSMSBalance')->name('sms.balance');
	Route::post('/company/details','HomeController@postCompanyDetails')->name('company.details.post');

	Route::get('/zones/transfer/{id}','zonesController@transferZone')->name('zone.transfer');

	//post routes
	Route::post('/nas/new/add','nasController@addNewNas')->name('nas.new.add');
	Route::post('/nas/edit','nasController@editNasSave')->name('nas.edit.post');
	//package post routes
	Route::post('/package/new','packagesController@savePackage')->name('package.save');
	Route::post('/package/edit/save','packagesController@savePackageChanges')->name('packages.edit.save');
	Route::post('/package/price','packagesController@savePackagePrice')->name('package.price.save');
	//maintenance post routes


	//managers post routes
	Route::post('/managers/create','managerController@postNewManager')->name('manager.new');
	//inventory post routes
	Route::post('/inventory/items/post','inventoryController@post_new_item')->name('item.post');
	Route::post('/inventory/products/post','inventoryController@post_new_product')->name('product.post');
	Route::post('/inventory/edit/item/save','inventoryController@save_edit_item')->name('item.post.edit');
	Route::post('/inventory/edit/product/save','inventoryController@save_edit_product')->name('product.post.edit');
	Route::post('/inventory/suppliers','inventoryController@supplier_new')->name('supplier.post.new');
	Route::post('/inventory/supplier/edit','inventoryController@save_edit_supplier')->name('supplier.post.edit');
	Route::post('/inventory/vendors/new','inventoryController@save_new_vendor')->name('vendor.post.new');
	Route::post('/inventory/vendors/edit','inventoryController@save_edit_vendor')->name('vendor.post.edit');
	Route::post('/inventory/categories','inventoryController@post_category')->name('category.new');
	Route::post('/inventory/subcategories','inventoryController@post_sub_category')->name('sub_category.new');
	//tickets pos
	
	Route::post('/tickets/new/auto','ticketsController@saveAutoGenTickets')->name('save.auto.tickets');
	//zone post routes
	Route::post('/zones/add','zonesController@addZone')->name('zones.add.new');
	Route::post('/zones/manager','zonesController@zoneManager')->name('zones.new.manager');
	Route::post('/zones/transfer','zonesController@transferZoneSave')->name('transfer.zone.save');
	Route::post('/zones/edit','zonesController@saveEditedZone')->name('save.edit.zone');

	Route::get('/sales/all','salesController@allSales')->name('sales.all');
	Route::get('/invoices/new','salesController@newInvoice')->name('new.invoice');
	Route::get('/Manager/payments','managerController@managersPayment')->name('manager.payment');
	Route::get('/payments','paymentsController@getAllPayments')->name('payment.all');

	Route::get('/manager/all','managerController@getAllManagers')->name('managers.all');
	Route::get('/managers/edit/{id}','managerController@getManagerEdit')->name('manager.edit');
	Route::get('/manager/delete/{id}','managerController@deleteManager')->name('manager.delete');
	Route::post('/managers/edit/post','managerController@saveManagerChanges')->name('manager.edit.post');



	Route::post('/managers/getTransactions','managerController@getManagerTransactions')->name('getManagerTransactions');
	Route::post('/managers/paymanager','managerController@payManager')->name('pay.manager');

	Route::post('/payment/via','paymentsController@payoption')->name('pay.option.select');
	Route::get('/payment/paypal','paymentsController@getPaypal')->name('paypal.payment');
	Route::get('/payment/stripe','paymentsController@getStripe')->name('stripe.payment');

    Route::get('/payment/mpesa','paymentsController@getMpesa')->name('mpesa.payment');

});
Route::get('/user/change/accounting/del/{username}','accountingController@deleteAccountingRec')->name('deleteaccts');
Route::get('/tickets/close/{id}','ticketsController@closeTicket')->name('sell.ticket');
Route::get('/nas/view','nasController@viewNas')->name('nas.view');
//users routes


Route::get('/users/all','userController@allUsers')->name('user.all');
Route::get('/users/get/all','userController@getUsers')->name('user.get.all');
Route::get('/users/changepackage','userController@changeUserPackage')->name('user.changepackage');
Route::get('/users/online','userController@onlineUsers')->name('user.online');
Route::get('/users/offline','userController@offlineUsers')->name('user.offline');
Route::get('/users/paid','userController@paidUsers')->name('user.paid');
Route::get('/users/unpaid','userController@unpaidUsers')->name('user.unpaid');
Route::get('/services/last-connections','servicesController@getLastConnAttempts')->name('last.conn.attempts');
Route::post('/clean/conn','servicesController@postCleanConn')->name('clean.stale');
Route::post('/users/changepackage','userController@changeCustomerPackage')->name('customer.changepackage.post');
Route::get('/logging/{en}','settingsController@Logging')->name('logging');
Route::post('/users/online','userController@getOnlineUser')->name('getonlineusers');
Route::post('/user/remove','userController@deleteuser')->name('removeuser');
Route::get('/user/customlimits','userController@getUserLimit')->name('getuserlimits');
Route::get('/user/customlimits/{id}','userController@deleteUserLimit')->name('deleteuserlimit');
Route::post('/user/customlimits','userController@postUserLimit')->name('postuserlimits');
//packages get routes


//maintenance get routes
Route::get('/services/status','servicesController@servicesStatus')->name('services.status');
Route::get('/services/testconnectivity/{user?}/{cleart?}','servicesController@testConnectivity')->name('services.testconnectivity');

Route::post('/services/testconn','servicesController@postTestConn')->name('testconn');

Route::get('/stale/connections','servicesController@getCleanStaleConns')->name('stale.conn');

//managers get routes

Route::get('/manager/profile','profileController@getProfile')->name('manager.profile');
//inventory


//tickets routes
Route::get('/tickets/open','ticketsController@render_tickets_open')->name('tickets.open');
Route::get('/user/accounts','userController@getUserAccounts')->name('customer.accounts');
Route::get('/user/accounts/edit/{acc?}','userController@getAccountEdit')->name('edit.customer.account');
Route::post('/user/accounts/edit','userController@postAccountUpdate')->name('edit.customer.account.post');
Route::get('/user/accounts/{id}','apiController@getAccount')->name('customer.accounts.one');
Route::get('/user/accounts/all/{username?}/{packageid?}','clientsController@getAllUserAccounts')->name('customer.accounts.all');
Route::post('/user/accounts','userController@postUserAccount')->name('customer.accounts.post');

//settings routes

//zone routes

Route::get('/zones/all','zonesController@allZones')->name('zone.all');
Route::get('/zones/edit/{id}','zonesController@editZone')->name('zone.edit');
Route::get('zones/delete/{id}','zonesController@deleteZone')->name('delete.zone');

//payments get routes
Route::get('/payments/option','paymentsController@selectPayOption')->name('pay.option');
//accounting records
Route::get('/accounting/user','accountingController@getUserAccounting')->name('user.accounting');
Route::get('/accounting/nas','accountingController@getNasAccounting')->name('nas.accounting');
Route::get('/accounting/ip','accountingController@getIpAccounting')->name('ip.accounting');
Route::get('/invoice/doc','salesController@invoicepdf')->name('invoice.doc');
Route::get('/customer_form/doc/{account_no}','userController@customerformpdf')->name('customer_form.doc');

Route::post('/accounting/user/get','accountingController@returnUserAccounting')->name('getuseraccountingdetails');

Route::post('/accounting/ip/get','accountingController@returnIpAccounting')->name('ipaccounting');

Route::post('/accounting/nas/get','accountingController@returnNasAccounting')->name('nasaccounting');
Route::get('/user/edit','userController@getUserEdit')->name('geteditcustomer');
Route::get('/user/change/{username?}','userController@getUserChange')->name('getchangecustomer');
Route::post('/user/specificuser','userController@getUserToEdit')->name('getspecificuser');
Route::post('/user/peruserlimit','userController@perUserLimit')->name('peruserlimit.post');
Route::post('/user/editattribute','userController@editAttribute')->name('edit_attr.post');
Route::post('/finance/invoice','salesController@postInvoice')->name('invoice.post');
Route::get('/user/change/checkattr/del/{id}','userController@deleteAttrcheck')->name('checkdeleteattr');
Route::get('/user/change/replyattr/del/{id}','userController@deleteAttrreply')->name('replydeleteattr');
//post routes
//nas post routes

//user post routes
Route::post('/user/new','userController@saveNewCustomer')->name('save.user');
Route::post('/user/updatedetails','userController@postUserPersonalDetails')->name('update.user.details');

//setting post routes
Route::post('/settings/man/comm','settingsController@addManagerCommission')->name('add.manager.commission');

///special posts
Route::post('/user/nas','userController@getNas')->name('getnas');
Route::post('/tickets/getcost','apiController@getPackageCost')->name('get.package.cost');
//user equipments
Route::post('user/equipment/new','userController@allocateEquipmet')->name('post.new.equipment');
Route::post('user/equipment/return','userController@returnEquipment')->name('return.equipment');
Route::get('/del/{id}','userController@deleteAllocation')->name('delete.equipment');















// clients routes
Route::get('/client/login','clientsController@getLogin')->name('clients.login');
Route::get('/client/bundles','clientsController@getBundles')->name('client.bundles');

Route::get('/connections/manage','clientsController@getCleanStale')->name('user.get.cleanstale');
Route::post('/connection/staleconn','clientsController@cleanStaleConn')->name('user.post.cleanstale');
Route::get('/buybundle/{id}/{account?}','clientsController@buyBundlePlan')->name('user.buybundleplan');
Route::post('/accounts/payfor','clientsController@AccountsPayFor')->name('account.payfor');
Route::get('/changephone','clientsController@getChangePhone')->name('user.changephone');
Route::get('/clients/accounts/suspend','clientsController@getSuspendAccount')->name('user.accounts.suspend');
Route::post('/changephone','clientsController@postChangePhone')->name('user.post.changephone');

Route::get('/bundlebalance','clientsController@bundlebalance')->name('user.balance');
Route::get('/packages/free/{id}/{acc?}','clientsController@getFreeAccess')->name('clients.freepackage');
Route::post('/bundlebalance','clientsController@fetchBalance')->name('user.check.balance');
Route::post('/buybundle','clientsController@payToGetCredentials')->name('pay.forcredentials');
Route::get('/transactions','clientsController@getTransactions')->name('user.transactions');
// Route::post('/purchase','clientsController@purchasePackage')->name('buybundle.post');
Route::post('/purchase','clientsController@payToGetCredentials')->name('buybundle.post');

Route::get('/customer/login/{usertype?}', 'Auth\LoginController@showCustomerLoginForm')->name('get.customer.login');
Route::get('/customer/register', 'Auth\RegisterController@showCustomerRegisterForm')->name('get.customer.register');
Route::post('/login/customer', 'Auth\LoginController@customerLogin')->name('post.customer.login');
Route::post('/register/customer', 'Auth\RegisterController@createCustomer')->name('post.customer.register');
Route::get('/customer/logout','clientsController@getLogout')->name('user.logout');
Route::get('/hotspot/packages','apiController@getHotspotPackages')->name('hotspot.packages');
Route::get('/client/account/suspend/{username}','clientsController@suspendAccount')->name('suspend.account');
Route::post('/client/account/suspend','clientsController@suspendAccount')->name('suspend.account');
Route::post('/account/activate','clientsController@activateSuspendedAccount')->name('activate.account');
Route::post('/account/pppoe/ractivate','userController@reactivatePPPoeAccount')->name('reactivate_pppoeuser');
Route::post('/riskfee','settingsController@postRiskFee')->name('post-risk-fee');
// Route::post('/account/check','clientsController@testingPPoe')->name('pppoe.test');
// Route::get('/account/check','clientsController@gettestingPPoe')->name('pppoe.test.get');
