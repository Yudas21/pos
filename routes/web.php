<?php

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

// Auth::routes();
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect(url(''));
});

Route::get('/', [ 'as' => 'login', 'uses' => 'LoginController@index']);

Route::post('login/check_login', 'LoginController@checkLogin');
Route::get('login/forgotpassword', 'LoginController@forgotPassword');
Route::post('login/pforgotpassword', 'LoginController@pForgotPassword');
Route::get('admin/dashboard', 'AdminController@index');
Route::get('admin/logout', 'AdminController@logout');
Route::get('admin/profile', 'AdminController@profile');
Route::patch('admin/update_profile/{profile}', 'AdminController@profile_update');
Route::patch('admin/update_password/{profile}', 'AdminController@password_update');
Route::patch('admin/change_photo', 'AdminController@change_photo');

Route::get('kasir/dashboard', 'KasirController@index');
Route::get('kasir/logout', 'KasirController@logout');
Route::get('kasir/profile', 'KasirController@profile');
Route::patch('kasir/update_profile/{profile}', 'KasirController@profile_update');
Route::patch('kasir/update_password/{profile}', 'KasirController@password_update');
Route::patch('kasir/change_photo', 'KasirController@change_photo');

Route::get('gudang/dashboard', 'GudangController@index');
Route::get('gudang/logout', 'GudangController@logout');
Route::get('gudang/profile', 'GudangController@profile');
Route::patch('gudang/update_profile/{profile}', 'GudangController@profile_update');
Route::patch('gudang/update_password/{profile}', 'GudangController@password_update');
Route::patch('gudang/change_photo', 'GudangController@change_photo');

Route::get('owner/dashboard', 'OwnerController@index');
Route::get('owner/logout', 'OwnerController@logout');
Route::get('owner/profile', 'OwnerController@profile');
Route::patch('owner/update_profile/{profile}', 'OwnerController@profile_update');
Route::patch('owner/update_password/{profile}', 'OwnerController@password_update');
Route::patch('owner/change_photo', 'OwnerController@change_photo');

// CRUD Users
Route::get('admin/users', 'AdminController@users');
Route::get('admin/data_users', 'AdminController@data_users');
Route::get('admin/users_level', 'AdminController@data_users_level');
Route::get('admin/users_type', 'AdminController@data_users_type');
Route::get('admin/daftar_branch', 'AdminController@data_users_branch');
Route::get('admin/search_users', 'AdminController@users_search');
Route::get('admin/add_users', 'AdminController@users_add');
Route::post('admin/store_users', 'AdminController@users_store');
Route::put('admin/update_users/{users}', 'AdminController@users_update');
Route::put('admin/update_password_users/{users}', 'AdminController@users_update_password');
Route::delete('admin/delete_users/{users}', 'AdminController@users_delete');
Route::get('admin/exporttoexcel_users', 'AdminController@exportToExcelUsers');

Route::get('admin/menu', 'AdminController@menu');
Route::get('admin/data_menu', 'AdminController@data_menu');
Route::get('admin/data_menu_parent', 'AdminController@menu_parent');
Route::get('admin/search_menu', 'AdminController@menu_search');
Route::post('admin/simpan_menu', 'AdminController@menu_store');
Route::put('admin/update_menu/{menu}', 'AdminController@menu_update');
Route::delete('admin/destroy_menu/{menu}', 'AdminController@menu_destroy');

Route::get('admin/level', 'AdminController@level');
Route::get('admin/data_level', 'AdminController@data_level');
Route::get('admin/search_level', 'AdminController@level_search');
Route::post('admin/simpan_level', 'AdminController@level_store');
Route::put('admin/update_level/{level}', 'AdminController@level_update');
Route::get('admin/access_level/{level}', 'AdminController@level_access');
Route::post('admin/update_access_level/{level}', 'AdminController@level_access_update');
Route::delete('admin/level_menu/{level}', 'AdminController@level_destroy');

Route::get('admin/users', 'AdminController@users');
Route::get('admin/data_users', 'AdminController@data_users');
Route::get('admin/users_level', 'AdminController@data_users_level');
Route::get('admin/search_users', 'AdminController@users_search');
Route::get('admin/add_users', 'AdminController@users_add');
Route::post('admin/store_users', 'AdminController@users_store');
Route::put('admin/update_users/{users}', 'AdminController@users_update');
Route::put('admin/update_password_users/{users}', 'AdminController@users_update_password');
Route::delete('admin/delete_users/{users}', 'AdminController@users_delete');

Route::get('admin/supplier', 'AdminController@supplier');
Route::get('admin/data_supplier', 'AdminController@data_supplier');
Route::get('admin/search_supplier', 'AdminController@supplier_search');
Route::post('admin/simpan_supplier', 'AdminController@supplier_store');
Route::put('admin/update_supplier/{supplier}', 'AdminController@supplier_update');
Route::delete('admin/destroy_supplier/{supplier}', 'AdminController@supplier_destroy');

Route::get('gudang/supplier', 'GudangController@supplier');
Route::get('gudang/data_supplier', 'GudangController@data_supplier');
Route::get('gudang/search_supplier', 'GudangController@supplier_search');
Route::post('gudang/simpan_supplier', 'GudangController@supplier_store');
Route::put('gudang/update_supplier/{supplier}', 'GudangController@supplier_update');
Route::delete('gudang/destroy_supplier/{supplier}', 'GudangController@supplier_destroy');

Route::get('admin/customer', 'AdminController@customer');
Route::get('admin/data_customer', 'AdminController@data_customer');
Route::get('admin/search_customer', 'AdminController@customer_search');
Route::post('admin/simpan_customer', 'AdminController@customer_store');
Route::put('admin/update_customer/{customer}', 'AdminController@customer_update');
Route::delete('admin/destroy_customer/{customer}', 'AdminController@customer_destroy');

Route::get('kasir/customer', 'KasirController@customer');
Route::get('kasir/data_customer', 'KasirController@data_customer');
Route::get('kasir/search_customer', 'KasirController@customer_search');
Route::post('kasir/simpan_customer', 'KasirController@customer_store');
Route::put('kasir/update_customer/{customer}', 'KasirController@customer_update');
Route::delete('kasir/destroy_customer/{customer}', 'KasirController@customer_destroy');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
