<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web roustes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Start Main Routes
Route::group([
    'namespace' => 'App\\Http\\Controllers\\Admin',
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale() . "/admin",
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function () {
    /* Start Login Routes */
    Route::group(['namespace' => 'Auth'], function () {
        Route::get("login", "LoginController@showLogin")->name('admin.login');
        Route::post("login", "LoginController@login")->name('admin.login');
        Route::get("logout", "LoginController@logout")->name('admin.logout');
        Route::get('login/forgot-password', 'LoginController@forgotPassword')->name('login.forgot-password');
        Route::post('login/forgot-password', 'LoginController@sendResetPassword')->name('password.email');
        Route::get('/reset-password/{token}', 'LoginController@resetPassword')->name('password.reset');
        Route::post('/reset-password', 'LoginController@doResetPassword')->name('password.update');
    });
    /* End Login Routes */

    /* Start Home Routes */
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', 'HomeController@index')->name("admin.home");
        /* Start Language Routes */
        Route::group([], function () {
            Route::get('languages', 'LanguageController@index')->name("languages.index");
            Route::get('languages/create', 'LanguageController@create')->name("languages.create");
            Route::post('languages/store', 'LanguageController@store')->name("languages.store");
            Route::get('languages/{id}/edit', 'LanguageController@edit')->name("languages.edit");
            Route::put('languages/{id}/update', 'LanguageController@update')->name("languages.update");
            Route::delete('languages/{id}/delete', 'LanguageController@destroy')->name("languages.destroy");
            Route::post('languages/{id}/activate', 'LanguageController@activate')->name("languages.activate");
        });
        /* Start Language Routes */

        /* Start User Routes */
        Route::group(['middleware' => ['role:super-admin|admin|moderator']], function () {
            Route::get('users', 'UserController@index')->name("users.index");
            Route::get('users/create', 'UserController@create')->name("users.create");
            Route::post('users/store', 'UserController@store')->name("users.store");
            Route::get('users/{id}/edit', 'UserController@edit')->name("users.edit");
            Route::put('users/{id}/update', 'UserController@update')->name("users.update");
            Route::delete('users/{id}/delete', 'UserController@destroy')->name("users.destroy");
            Route::post('users/{id}/activate', 'UserController@activate')->name("users.activate");
        });
        /* Start User Routes */

        /* Start Emplyee Role Routes */
        Route::group(['middleware' => ['role:super-admin|admin|moderator']], function () {
            Route::get('roles', 'RoleController@index')->name("roles.index");
            Route::get('roles/create', 'RoleController@create')->name("roles.create");
            Route::post('roles/store', 'RoleController@store')->name("roles.store");
            Route::get('roles/{id}/edit', 'RoleController@edit')->name("roles.edit");
            Route::put('roles/{id}/update', 'RoleController@update')->name("roles.update");
            Route::delete('roles/{id}/delete', 'RoleController@destroy')->name("roles.destroy");
            Route::post('roles/{id}/activate', 'RoleController@activate')->name("roles.activate");
        });
        /* Start User Role Routes */

        /* Start Permission Routes */
        Route::group(['middleware' => ['role:super-admin|admin|moderator']], function () {
            Route::get('permissions', 'PermissionController@index')->name("permissions.index");
            Route::get('permissions/create', 'PermissionController@create')->name("permissions.create");
            Route::post('permissions/store', 'PermissionController@store')->name("permissions.store");
            Route::get('permissions/{id}/edit', 'PermissionController@edit')->name("permissions.edit");
            Route::put('permissions/{id}/update', 'PermissionController@update')->name("permissions.update");
            Route::delete('permissions/{id}/delete', 'PermissionController@destroy')->name("permissions.destroy");
            Route::post('permissions/{id}/activate', 'PermissionController@activate')->name("permissions.activate");
        });
        /* Start Permission Routes */



        /* Start Vendor Routes */
        Route::group([], function () {
            Route::get('vendors', 'VendorController@index')->name("vendors.index")->middleware('permission:show-vendor');
            Route::get('vendors/create', 'VendorController@create')->name("vendors.create")->middleware('permission:add-vendor');
            Route::post('vendors/store', 'VendorController@store')->name("vendors.store");
            Route::get('vendors/{id}/edit', 'VendorController@edit')->name("vendors.edit")->middleware('permission:edit-vendor');
            Route::put('vendors/{id}/update', 'VendorController@update')->name("vendors.update");
            Route::delete('vendors/{id}/delete', 'VendorController@destroy')->name("vendors.destroy")->middleware('permission:delete-vendor');
            Route::post('vendors/{id}/activate', 'VendorController@activate')->name("vendors.activate")->middleware('permission:activate-vendor');
            Route::get('vendors/{id}/show', 'VendorController@show')->name("vendors.show");
        });
        /* Start Vendor Routes */

        /* Start Employees Routes */
        Route::group([], function () {
            Route::get('employees', 'EmployeeController@index')->name("employees.index")->middleware('permission:show-employee');
            Route::get('employees/create', 'EmployeeController@create')->name("employees.create")->middleware('permission:add-employee');
            Route::post('employees/store', 'EmployeeController@store')->name("employees.store");
            Route::get('employees/{id}/edit', 'EmployeeController@edit')->name("employees.edit")->middleware('permission:edit-employee');
            Route::put('employees/{id}/update', 'EmployeeController@update')->name("employees.update");
            Route::delete('employees/{id}/delete', 'EmployeeController@destroy')->name("employees.destroy")->middleware('permission:delete-employee');
            Route::post('employees/{id}/activate', 'EmployeeController@activate')->name("employees.activate")->middleware('permission:activate-employee');
        });
        /* Start Employees Routes */

        /* Start Employees_groups Routes */
        Route::group([], function () {
            Route::get('employees_groups', 'EmployeeGroupController@index')->name("employees_groups.index");
            Route::get('employees_groups/create', 'EmployeeGroupController@create')->name("employees_groups.create");
            Route::post('employees_groups/store', 'EmployeeGroupController@store')->name("employees_groups.store");
            Route::get('employees_groups/{id}/edit', 'EmployeeGroupController@edit')->name("employees_groups.edit");
            Route::put('employees_groups/{id}/update', 'EmployeeGroupController@update')->name("employees_groups.update");
            Route::delete('employees_groups/{id}/delete', 'EmployeeGroupController@destroy')->name("employees_groups.destroy");
            Route::post('employees_groups/{id}/activate', 'EmployeeGroupController@activate')->name("employees_groups.activate");
        });
        /* Start Employees_groups Routes */

        /* Start Company Branches Routes */
        Route::group([], function () {
            Route::get('branches', 'CompanyBranchController@index')->name("branches.index")->middleware('permission:show-branch');
            Route::get('branches/create', 'CompanyBranchController@create')->name("branches.create")->middleware('permission:add-branch');
            Route::post('branches/store', 'CompanyBranchController@store')->name("branches.store");
            Route::get('branches/{id}/edit', 'CompanyBranchController@edit')->name("branches.edit")->middleware('permission:edit-branch');
            Route::put('branches/{id}/update', 'CompanyBranchController@update')->name("branches.update");
            Route::delete('branches/{id}/delete', 'CompanyBranchController@destroy')->name("branches.destroy")->middleware('permission:delete-branch');
            Route::post('branches/{id}/activate', 'CompanyBranchController@activate')->name("branches.activate")->middleware('permission:activate-branch');
        });
        /* Start Company Branches Routes */

        /* Start Store Routes */
        Route::group([], function () {
            Route::get('stores', 'StoreController@index')->name("stores.index")->middleware('permission:show-store');
            Route::get('stores/create', 'StoreController@create')->name("stores.create")->middleware('permission:add-store');
            Route::post('stores/store', 'StoreController@store')->name("stores.store");
            Route::get('stores/{id}/edit', 'StoreController@edit')->name("stores.edit")->middleware('permission:edit-store');
            Route::put('stores/{id}/update', 'StoreController@update')->name("stores.update");
            Route::delete('stores/{id}/delete', 'StoreController@destroy')->name("stores.destroy")->middleware('permission:delete-store');
            Route::post('stores/{id}/activate', 'StoreController@activate')->name("stores.activate")->middleware('permission:activate-store');
        });
        /* Start Store Routes */

        /* Start Unit Routes */
        Route::group([], function () {
            Route::get('units', 'UnitController@index')->name("units.index")->middleware('permission:show-unit');
            Route::get('units/create', 'UnitController@create')->name("units.create")->middleware('permission:add-unit');
            Route::post('units/store', 'UnitController@store')->name("units.store");
            Route::get('units/{id}/edit', 'UnitController@edit')->name("units.edit")->middleware('permission:edit-unit');
            Route::put('units/{id}/update', 'UnitController@update')->name("units.update");
            Route::delete('units/{id}/delete', 'UnitController@destroy')->name("units.destroy")->middleware('permission:delete-unit');
            Route::post('units/{id}/activate', 'UnitController@activate')->name("units.activate")->middleware('permission:activate-unit');
        });
        /* Start Unit Routes */

        /* Start main-categories Routes */
        Route::group([], function () {
            Route::get('main-categories', 'MainCategoryController@index')->name("main-categories.index")->middleware('permission:show-main-category');
            Route::get('main-categories/create', 'MainCategoryController@create')->name("main-categories.create")->middleware('permission:add-main-category');
            Route::post('main-categories/store', 'MainCategoryController@store')->name("main-categories.store");
            Route::get('main-categories/{id}/edit', 'MainCategoryController@edit')->name("main-categories.edit")->middleware('permission:edit-main-category');
            Route::put('main-categories/{id}/update', 'MainCategoryController@update')->name("main-categories.update");
            Route::delete('main-categories/{id}/delete', 'MainCategoryController@destroy')->name("main-categories.destroy")->middleware('permission:delete-main-category');
            Route::post('main-categories/{id}/activate', 'MainCategoryController@activate')->name("main-categories.activate")->middleware('permission:activate-main-category');
        });
        /* Start main-categories Routes */

        /* Start sub-categories Routes */
        Route::group([], function () {
            Route::get('sub-categories', 'SubCategoryController@index')->name("sub-categories.index")->middleware('permission:show-sub-category');
            Route::get('sub-categories/create', 'SubCategoryController@create')->name("sub-categories.create")->middleware('permission:add-sub-category');
            Route::post('sub-categories/store', 'SubCategoryController@store')->name("sub-categories.store");
            Route::get('sub-categories/{id}/edit', 'SubCategoryController@edit')->name("sub-categories.edit")->middleware('permission:edit-sub-category');
            Route::put('sub-categories/{id}/update', 'SubCategoryController@update')->name("sub-categories.update");
            Route::delete('sub-categories/{id}/delete', 'SubCategoryController@destroy')->name("sub-categories.destroy")->middleware('permission:delete-sub-category');
            Route::post('sub-categories/{id}/activate', 'SubCategoryController@activate')->name("sub-categories.activate")->middleware('permission:activate-sub-category');
            Route::get('sub-categories/{id}/show', 'SubCategoryController@show')->name("sub-categories.show")->middleware('permission:show-sub-category-children');
        });
        /* Start sub-categories Routes */

        /* Start items Routes */
        Route::group([], function () {
            Route::get('items', 'ItemController@index')->name("items.index")->middleware('permission:show-item');
            Route::get('items/create', 'ItemController@create')->name("items.create")->middleware('permission:add-item');
            Route::post('items/store', 'ItemController@store')->name("items.store");
            Route::get('items/{id}/edit', 'ItemController@edit')->name("items.edit")->middleware('permission:edit-item');
            Route::put('items/{id}/update', 'ItemController@update')->name("items.update");
            Route::delete('items/{id}/delete', 'ItemController@destroy')->name("items.destroy")->middleware('permission:delete-item');
            Route::post('items/{id}/activate', 'ItemController@activate')->name("items.activate")->middleware('permission:activate-item');
            Route::post('items/{id}/getDetail', 'ItemController@getMainCatDetail')->name("items.getMainCatDetail");
            Route::POST('items/{id}/get_sub_categories', 'ItemController@getSubCategories')->name("items.get_sub_categories");
            Route::POST('items/{id}/get_branch_stores', 'ItemController@getBranchStores')->name("items.get_branch_stores");
            Route::GET('items/{id}/show', 'ItemController@show')->name("items.show");
        });
        /* Start items Routes */

        /* Start coins Routes */
        Route::group([], function () {
            Route::get('coins', 'CoinController@index')->name("coins.index")->middleware('permission:show-coin');
            Route::get('coins/create', 'CoinController@create')->name("coins.create")->middleware('permission:add-coin');
            Route::post('coins/store', 'CoinController@store')->name("coins.store");
            Route::get('coins/{id}/edit', 'CoinController@edit')->name("coins.edit")->middleware('permission:edit-coin');
            Route::put('coins/{id}/update', 'CoinController@update')->name("coins.update");
            Route::delete('coins/{id}/delete', 'CoinController@destroy')->name("coins.destroy")->middleware('permission:delete-coin');
            Route::post('coins/{id}/activate', 'CoinController@activate')->name("coins.activate")->middleware('permission:activate-coin');
        });
        /* Start coins Routes */

        /* Start transferQuantity Routes */
        Route::group([], function () {
            Route::get('trans_quantity', 'TransQuantityController@index')->name("trans_quantity.index")->middleware('permission:show-store-trans-operation');
            Route::get('trans_quantity/create', 'TransQuantityController@create')->name("trans_quantity.create")->middleware('permission:add-store-trans-operation');
            Route::post('trans_quantity/store', 'TransQuantityController@store')->name("trans_quantity.store");
            Route::get('trans_quantity/{id}/edit', 'TransQuantityController@edit')->name("trans_quantity.edit")->middleware('permission:edit-store-trans-operation');
            Route::put('trans_quantity/{id}/update', 'TransQuantityController@update')->name("trans_quantity.update");
            Route::get('trans_quantity/{id}/trans_detail', 'TransQuantityController@getOperationDetail')->name("trans_quantity.trans_detail")->middleware('permission:show-store-trans-operation_detail');
            Route::POST('trans_quantity/{id}/get_branch_stores', 'TransQuantityController@getBranchStores')->name("trans_quantity.get_branch_stores");
            Route::Delete('trans_quantity/{id}/delete', 'TransQuantityController@destroy')->name("trans_quantity.destroy");
            Route::POST('trans_quantity/{id}/relay', 'TransQuantityController@relayTrans')->name("trans_quantity.relay");
        });
        /* Start transferQuantity Routes */

        /* Start Payable Entry Routes */
        Route::group([], function () {
            Route::get('payable_entries', 'PayableEntryController@index')->name("payable_entries.index")->middleware('permission:show-payable-entry');
            Route::get('payable_entries/create', 'PayableEntryController@create')->name("payable_entries.create")->middleware('permission:add-payable-entry');
            Route::post('payable_entries/store', 'PayableEntryController@store')->name("payable_entries.store");
            Route::get('payable_entries/{id}/edit', 'PayableEntryController@edit')->name("payable_entries.edit")->middleware('permission:edit-payable-entry');
            Route::put('payable_entries/{id}/update', 'PayableEntryController@update')->name("payable_entries.update");
            Route::get('payable_entries/{id}/show', 'PayableEntryController@show')->name("payable_entries.show")->middleware('permission:show-payable-entry-detail');
            Route::POST('payable_entries/{id}/get_branch_stores', 'PayableEntryController@getBranchStores')->name("payable_entries.get_branch_stores");
            Route::Delete('payable_entries/{id}/delete', 'PayableEntryController@destroy')->name("payable_entries.destroy");
            Route::POST('payable_entries/{id}/relay', 'PayableEntryController@relayTrans')->name("payable_entries.relay");
        });
        /* Start Payable Entry Routes */

        /* Start receivable Entry Routes */
        Route::group([], function () {
            Route::get('receivable_entries', 'ReceivableEntryController@index')->name("receivable_entries.index");
            Route::get('receivable_entries/create', 'ReceivableEntryController@create')->name("receivable_entries.create");
            Route::post('receivable_entries/store', 'ReceivableEntryController@store')->name("receivable_entries.store");
            Route::get('receivable_entries/{id}/edit', 'ReceivableEntryController@edit')->name("receivable_entries.edit");
            Route::put('receivable_entries/{id}/update', 'ReceivableEntryController@update')->name("receivable_entries.update");
            Route::get('receivable_entries/{id}/show', 'ReceivableEntryController@show')->name("receivable_entries.show");
            Route::POST('receivable_entries/{id}/get_branch_stores', 'ReceivableEntryController@getBranchStores')->name("receivable_entries.get_branch_stores");
            Route::Delete('receivable_entries/{id}/delete', 'ReceivableEntryController@destroy')->name("receivable_entries.destroy");
            Route::POST('receivable_entries/{id}/relay', 'ReceivableEntryController@relayTrans')->name("receivable_entries.relay");
        });
        /* Start receivable Entry Routes */

        /* Start inventory Entry Routes */
        Route::group([], function () {
            Route::get('inventory_entries', 'InventoryEntryController@index')->name("inventory_entries.index");
            Route::get('inventory_entries/create', 'InventoryEntryController@create')->name("inventory_entries.create");
            Route::post('inventory_entries/store', 'InventoryEntryController@store')->name("inventory_entries.store");
            Route::get('inventory_entries/{id}/show', 'InventoryEntryController@show')->name("inventory_entries.show");
            Route::POST('inventory_entries/{id}/get_branch_stores', 'InventoryEntryController@getBranchStores')->name("inventory_entries.get_branch_stores");
            Route::delete('inventory_entries/{id}/delete', 'InventoryEntryController@destroy')->name("inventory_entries.destroy");
        });
        /* Start inventory Entry Routes */

        /* Start out stock Routes */
        Route::group([], function () {
            Route::get('out_stock', 'OutStockController@index')->name("out_stock.index");
            Route::get('out_stock/create', 'OutStockController@create')->name("out_stock.create");
            Route::post('out_stock/store', 'OutStockController@store')->name("out_stock.store");
            Route::get('out_stock/{id}/show', 'OutStockController@show')->name("out_stock.show");
            Route::POST('out_stock/{id}/get_branch_stores', 'OutStockController@getBranchStores')->name("out_stock.get_branch_stores");
            Route::delete('out_stock/{id}/delete', 'OutStockController@destroy')->name("out_stock.destroy");
        });
        /* Start out stock Routes */

        /* Start perishables Routes */
        Route::group([], function () {
            Route::get('perishables', 'PerishableController@index')->name("perishables.index");
            Route::get('perishables/create', 'PerishableController@create')->name("perishables.create");
            Route::post('perishables/store', 'PerishableController@store')->name("perishables.store");
            Route::get('perishables/{id}/edit', 'PerishableController@edit')->name("perishables.edit");
            Route::put('perishables/{id}/update', 'PerishableController@update')->name("perishables.update");
            Route::get('perishables/{id}/show', 'PerishableController@show')->name("perishables.show");
            Route::POST('perishables/{id}/get_branch_stores', 'PerishableController@getBranchStores')->name("perishables.get_branch_stores");
            Route::POST('perishables/{id}/get_store_items', 'PerishableController@getStoreItems')->name("perishables.get_store_items");
            Route::delete('perishables/{id}/delete', 'PerishableController@destroy')->name("perishables.destroy");
            Route::POST('perishables/{id}/relay', 'PerishableController@relayTrans')->name("perishables.relay");
        });
        /* Start perishables Routes */

        /* Start Client Routes */
        Route::group([], function () {
            Route::get('clients', 'ClientController@index')->name("clients.index")->middleware('permission:show-client');
            Route::get('clients/create', 'ClientController@create')->name("clients.create")->middleware('permission:add-client');
            Route::post('clients/store', 'ClientController@store')->name("clients.store");
            Route::get('clients/{id}/edit', 'ClientController@edit')->name("clients.edit")->middleware('permission:edit-client');
            Route::put('clients/{id}/update', 'ClientController@update')->name("clients.update");
            Route::delete('clients/{id}/delete', 'ClientController@destroy')->name("clients.destroy")->middleware('permission:delete-client');
            Route::post('clients/{id}/activate', 'ClientController@activate')->name("clients.activate")->middleware('permission:activate-client');
            Route::get('clients/{id}/show', 'ClientController@show')->name("clients.show");
        });
        /* Start Client Routes */

        /* Start Client Groups Routes */
        Route::group([], function () {
            Route::get('clients_groups', 'ClientGroupController@index')->name("clients_groups.index")->middleware('permission:show-client-group');
            Route::get('clients_groups/create', 'ClientGroupController@create')->name("clients_groups.create")->middleware('permission:add-client-group');
            Route::post('clients_groups/store', 'ClientGroupController@store')->name("clients_groups.store");
            Route::get('clients_groups/{id}/edit', 'ClientGroupController@edit')->name("clients_groups.edit")->middleware('permission:edit-client-group');
            Route::put('clients_groups/{id}/update', 'ClientGroupController@update')->name("clients_groups.update");
            Route::delete('clients_groups/{id}/delete', 'ClientGroupController@destroy')->name("clients_groups.destroy")->middleware('permission:delete-client-group');
            Route::post('clients_groups/{id}/activate', 'ClientGroupController@activate')->name("clients_groups.activate")->middleware('permission:activate-client-group');
        });
        /* Start Client Groups Routes */

        /* Start Client Groups Routes */
        Route::group([], function () {
            Route::get('invoice_types', 'InvoiceTypeController@index')->name("invoice_types.index");
            Route::get('invoice_types/create', 'InvoiceTypeController@create')->name("invoice_types.create");
            Route::post('invoice_types/store', 'InvoiceTypeController@store')->name("invoice_types.store");
            Route::get('invoice_types/{id}/edit', 'InvoiceTypeController@edit')->name("invoice_types.edit");
            Route::put('invoice_types/{id}/update', 'InvoiceTypeController@update')->name("invoice_types.update");
            Route::delete('invoice_types/{id}/delete', 'InvoiceTypeController@destroy')->name("invoice_types.destroy");
        });
        /* Start Client Groups Routes */

        /* Start prices-offers Routes */
        Route::group([], function () {
            Route::get('prices_offers', 'PriceOfferController@index')->name("prices_offers.index");
            Route::get('pirces_offers/create', 'PriceOfferController@create')->name("prices_offers.create");
            Route::post('prices_offers/store', 'PriceOfferController@store')->name("prices_offers.store");
            Route::get('prices_offers/{id}/edit', 'PriceOfferController@edit')->name("prices_offers.edit");
            Route::put('prices_offers/{id}/update', 'PriceOfferController@update')->name("prices_offers.update");
            Route::get('prices_offers/{id}/show', 'PriceOfferController@show')->name("prices_offers.show");
            Route::POST('prices_offers/{id}/get_branch_stores', 'PriceOfferController@getBranchStores')->name("prices_offers.get_branch_stores");
            Route::POST('prices_offers/{id}/get_store_items', 'PriceOfferController@getStoreItems')->name("prices_offers.get_store_items");
            Route::delete('prices_offers/{id}/delete', 'PriceOfferController@destroy')->name("prices_offers.destroy");
        });
        /* Start prices-offers Routes */

        /* Start sales_invoices Routes */
        Route::group([], function () {
            Route::get('sales_invoices', 'SalesInvoiceController@index')->name("sales_invoices.index");
            Route::get('sales_invoices/create', 'SalesInvoiceController@create')->name("sales_invoices.create");
            Route::post('sales_invoices/store', 'SalesInvoiceController@store')->name("sales_invoices.store");
            Route::get('sales_invoices/{id}/edit', 'SalesInvoiceController@edit')->name("sales_invoices.edit");
            Route::put('sales_invoices/{id}/update', 'SalesInvoiceController@update')->name("sales_invoices.update");
            Route::get('sales_invoices/{id}/show', 'SalesInvoiceController@show')->name("sales_invoices.show");
            Route::POST('sales_invoices/{id}/get_branch_stores', 'SalesInvoiceController@getBranchStores')->name("sales_invoices.get_branch_stores");
            Route::POST('sales_invoices/{id}/get_store_items', 'SalesInvoiceController@getStoreItems')->name("sales_invoices.get_store_items");
            Route::POST('sales_invoices/get_unit_detail', 'SalesInvoiceController@getUnitDetail')->name("sales_invoices.get_unit_detail");
            Route::delete('sales_invoices/{id}/delete', 'SalesInvoiceController@destroy')->name("sales_invoices.destroy");
            Route::POST('sales_invoices/{id}/relay', 'SalesInvoiceController@relayInvoice')->name("sales_invoices.relay");
        });
        /* Start sales_invoices Routes */

        /* Start purchases_invoices Routes */
        Route::group([], function () {
            Route::get('purchases_invoices', 'PurchaseInvoiceController@index')->name("purchases_invoices.index");
            Route::get('purchases_invoices/create', 'PurchaseInvoiceController@create')->name("purchases_invoices.create");
            Route::post('purchases_invoices/store', 'PurchaseInvoiceController@store')->name("purchases_invoices.store");
            Route::get('purchases_invoices/{id}/edit', 'PurchaseInvoiceController@edit')->name("purchases_invoices.edit");
            Route::put('purchases_invoices/{id}/update', 'PurchaseInvoiceController@update')->name("purchases_invoices.update");
            Route::get('purchases_invoices/{id}/show', 'PurchaseInvoiceController@show')->name("purchases_invoices.show");
            Route::POST('purchases_invoices/{id}/get_branch_stores', 'PurchaseInvoiceController@getBranchStores')->name("purchases_invoices.get_branch_stores");
            Route::POST('purchases_invoices/{id}/get_store_items', 'PurchaseInvoiceController@getStoreItems')->name("purchases_invoices.get_store_items");
            Route::POST('purchases_invoices/get_unit_detail', 'PurchaseInvoiceController@getUnitDetail')->name("purchases_invoices.get_unit_detail");
            Route::delete('purchases_invoices/{id}/delete', 'PurchaseInvoiceController@destroy')->name("purchases_invoices.destroy");
            Route::POST('purchases_invoices/{id}/relay', 'PurchaseInvoiceController@relayInvoice')->name("purchases_invoices.relay");
        });
        /* Start purchases_invoices Routes */

        /* Start return_sales_invoices Routes */
        Route::group([], function () {
            Route::get('return_sales_invoices', 'ReturnSalesInvoiceController@index')->name("return_sales_invoices.index");
            Route::get('return_sales_invoices/create', 'ReturnSalesInvoiceController@create')->name("return_sales_invoices.create");
            Route::post('return_sales_invoices/store', 'ReturnSalesInvoiceController@store')->name("return_sales_invoices.store");
            Route::get('return_sales_invoices/{id}/edit', 'ReturnSalesInvoiceController@edit')->name("return_sales_invoices.edit");
            Route::put('return_sales_invoices/{id}/update', 'ReturnSalesInvoiceController@update')->name("return_sales_invoices.update");
            Route::get('return_sales_invoices/{id}/show', 'ReturnSalesInvoiceController@show')->name("return_sales_invoices.show");
            Route::POST('return_sales_invoices/{id}/get_branch_stores', 'ReturnSalesInvoiceController@getBranchStores')->name("return_sales_invoices.get_branch_stores");
            Route::POST('return_sales_invoices/{id}/get_store_items', 'ReturnSalesInvoiceController@getStoreItems')->name("return_sales_invoices.get_store_items");
            Route::POST('return_sales_invoices/{id}/get_client_invoices', 'ReturnSalesInvoiceController@getClientInvoices')->name("return_sales_invoices.get_client_invoices");
            Route::POST('return_sales_invoices/{id}/get_invoice_detail', 'ReturnSalesInvoiceController@getInvoiceDetail')->name("return_sales_invoices.get_invoice_detail");
            Route::POST('return_sales_invoices/get_unit_detail', 'ReturnSalesInvoiceController@getUnitDetail')->name("return_sales_invoices.get_unit_detail");
            Route::delete('return_sales_invoices/{id}/delete', 'ReturnSalesInvoiceController@destroy')->name("return_sales_invoices.destroy");
            Route::POST('return_sales_invoices/{id}/relay', 'ReturnSalesInvoiceController@relayInvoice')->name("return_sales_invoices.relay");
        });
        /* Start return_sales_invoices Routes */

        /* Start return_purchases_invoices Routes */
        Route::group([], function () {
            Route::get('return_purchases_invoices', 'ReturnPurchasesInvoiceController@index')->name("return_purchases_invoices.index");
            Route::get('return_purchases_invoices/create', 'ReturnPurchasesInvoiceController@create')->name("return_purchases_invoices.create");
            Route::post('return_purchases_invoices/store', 'ReturnPurchasesInvoiceController@store')->name("return_purchases_invoices.store");
            Route::get('return_purchases_invoices/{id}/edit', 'ReturnPurchasesInvoiceController@edit')->name("return_purchases_invoices.edit");
            Route::put('return_purchases_invoices/{id}/update', 'ReturnPurchasesInvoiceController@update')->name("return_purchases_invoices.update");
            Route::get('return_purchases_invoices/{id}/show', 'ReturnPurchasesInvoiceController@show')->name("return_purchases_invoices.show");
            Route::POST('return_purchases_invoices/{id}/get_branch_stores', 'ReturnPurchasesInvoiceController@getBranchStores')->name("return_purchases_invoices.get_branch_stores");
            Route::POST('return_purchases_invoices/{id}/get_store_items', 'ReturnPurchasesInvoiceController@getStoreItems')->name("return_purchases_invoices.get_store_items");
            Route::POST('return_purchases_invoices/get_unit_detail', 'ReturnPurchasesInvoiceController@getUnitDetail')->name("return_purchases_invoices.get_unit_detail");
            Route::delete('return_purchases_invoices/{id}/delete', 'ReturnPurchasesInvoiceController@destroy')->name("return_purchases_invoices.destroy");
            Route::POST('return_purchases_invoices/{id}/relay', 'ReturnPurchasesInvoiceController@relayInvoice')->name("return_purchases_invoices.relay");
        });
        /* Start return_purchases_invoices Routes */

    });
});
