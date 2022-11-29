<?php
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function() {
	return view('auth.login');
});
Route::get('/dashboard', 'DashboardController@index')->middleware('auth')->name('dashboard');

Auth::routes();

Route::get('init', function(){
	\Illuminate\Support\Facades\Artisan::call('storage:link');
	\Illuminate\Support\Facades\Artisan::call('key:generate');
	\Illuminate\Support\Facades\Artisan::call('view:clear');
	\Illuminate\Support\Facades\Artisan::call('config:cache');
	\Illuminate\Support\Facades\Artisan::call('migrate:fresh');
	\Illuminate\Support\Facades\Artisan::call('db:seed');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::middleware(['auth'])->group(function () {
	Route::get('order/json/{page}/{limit}', 'OrderController@json')->name('order.json');
	Route::post('order/dataByBranch', 'OrderController@dataByBranch')->name('order.dataByBranch');
	Route::post('order/checkQuota', 'OrderController@checkQuota')->name('order.check-quota');
	Route::post('order/getDetailPackage', 'OrderController@getDetailPackage')->name('order.getDetailPackage');
	Route::post('order/showCardPackage', 'OrderController@showCardPackage')->name('order.showCardPackage');
	Route::post('order/showFileUploader', 'OrderController@showFileUploader')->name('order.showFileUploader');
	Route::post('order_detail/store-customer-information' , 'OrderController@storeCustomerInformation')->name('order.store-customer-information');
	Route::post('order_detail/store-order-information' , 'OrderController@storeOrderInformation')->name('order.store-order-information');
	Route::post('order/getVillage', 'OrderController@getVillages')->name('order.getVillages');
	Route::post('order/update/data/{id}', 'OrderController@update')->name('order.update-data');
	Route::post('order/helper', 'OrderController@helpers')->name('order.helper');
	Route::post('order/export', 'OrderController@exportInvoice')->name('order.export');
	Route::get('order/invoice/{id}', 'OrderController@invoice')->name('order.invoice');
	Route::get('order/kitchen/{id}', 'OrderController@kitchenInvoice')->name('order.kitchen-invoice');
	Route::resource('order', OrderController::class);
});

// user
Route::group([
	'prefix' => 'users',
	'middleware' => ['auth']
], function() {
	Route::get('/', 'UsersController@index')->name('users.index');
	Route::get('/init', 'UsersController@init')->name('users.init');
	Route::get('/generalData', 'UsersController@generalData')->name('users.generalData');
	Route::get('/edit/{id}', 'UsersController@edit')->name("users.edit");
	Route::get('/detail/{id}', 'UsersController@detail')->name("users.detail");
	Route::get('/json/{page}/{limit}', 'UsersController@json')->name("users.json");
	Route::post('/update', 'UsersController@update')->name('users.update');
	Route::post('/store', 'UsersController@store')->name('users.store');
	Route::post('/delete', 'UsersController@delete')->name('users.delete');
});

// branch
Route::group([
	'prefix' => 'branch',
	'middleware' => ['auth']
], function() {
	Route::get('/', 'BranchController@index')->name('branch.index');
	Route::get('/edit/{id}', 'BranchController@edit')->name("branch.edit");
	Route::get('/detail/{id}', 'BranchController@detail')->name("branch.detail");
	Route::get('/json/{page}/{limit}', 'BranchController@json')->name("branch.json");
	Route::get('/list', 'BranchController@list')->name('branch.list');
	Route::post('/update', 'BranchController@update')->name('branch.update');
	Route::post('/store', 'BranchController@store')->name('branch.store');
	Route::post('/delete', 'BranchController@delete')->name('branch.delete');
});

// role
Route::group([
	'prefix' => 'role',
	'middleware' => ['auth']
], function() {
	Route::get('/', 'RoleController@index')->name('role.index');
	Route::get('/edit/{id}', 'RoleController@edit')->name("role.edit");
	Route::get('/detail/{id}', 'RoleController@detail')->name("role.detail");
	Route::get('/json/{page}/{limit}', 'RoleController@json')->name("role.json");
	Route::post('/update', 'RoleController@update')->name('role.update');
	Route::post('/store', 'RoleController@store')->name('role.store');
	Route::post('/delete', 'RoleController@delete')->name('role.delete');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	Route::get('/', 'Admin\HomeController@index')->name('home');
	Route::get('/create', 'Admin\HomeController@create')->name('create');
	Route::get('/list', 'Admin\HomeController@list')->name('list');
});

Route::group(['prefix' => 'kepala_cabang', 'as' => 'kepala_cabang.', 'middleware' => 'kepala.cabang'], function () {
	Route::get('/', 'KepalaCabang\HomeController@index')->name('home');
});

Route::group(['prefix' => 'kaptain_dapur', 'as' => 'kaptain_dapur.', 'middleware' => 'kaptain.dapur'], function () {
	Route::get('/', 'KaptainDapur\HomeController@index')->name('home');
});

Route::group(['prefix' => 'cs', 'as' => 'cs.', 'middleware' => 'cs'], function () {
	Route::get('/', 'CS\HomeController@index')->name('home');
});

Route::group(['prefix' => 'crew', 'as' => 'crew.', 'middleware' => 'crew'], function () {
	Route::get('/', 'Crew\HomeController@index')->name('home');
});

Route::group(['prefix' => 'direktur', 'as' => 'direktur.', 'middleware' => 'direktur'], function () {
	Route::get('/', 'Direktur\HomeController@index')->name('home');
});

Route::group(['prefix' => 'manager', 'as' => 'manager.', 'middleware' => 'manager'], function () {
	Route::get('/', 'Manager\HomeController@index')->name('home');
});

Route::group(['prefix' => 'ppic', 'as' => 'ppic.', 'middleware' => 'ppic'], function () {
	Route::get('/', 'Ppic\HomeController@index')->name('home');
});