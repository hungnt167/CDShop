<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes...
Route::get('auth/login', 'AuthController@getLogin');
Route::get('auth/register', 'AuthController@getRegister');
Route::post('auth/register', 'AuthController@postRegister');
Route::post('auth/login', 'AuthController@postLogin');
Route::get('auth/logout', 'AuthController@getLogout');
Route::post('auth/resetPassword', 'AuthController@resetPassword');
//change password
Route::get('auth/change-Password', 'AuthController@getChangePassword');
Route::post('auth/changePassword', 'AuthController@postChangePassword');

//create customer
Route::post('create-customer', 'AuthController@createCustomer');
//update payment add
Route::get('update-customer', 'AuthController@getUpdatePaymentAddressCustomer');
Route::post('do-update-customer', 'AuthController@postUpdatePaymentAddressCustomer');

//send mail test
Route::get('sendmail', 'TestController@sendmail');
Route::post('testF', 'TestController@test');
//file
Route::any('up', 'TestController@file');
//test
Route::get('test', function(){
    return view('test.index');
});
Route::any('test/test','TestController@test' );

//success active
Route::get('active_success', function(){
    return view('auth.active_success');
});
//error
Route::get('error', function(){
    return view('errors.503');
});

//Frontend
Route::any('home', 'FrontendController@index');
Route::any('music-kingdom/page/{page}', 'FrontendController@musicKingdom');

Route::get('cart', 'FrontendController@cart');
Route::post('addToCart', 'CartController@addToCart');
Route::post('changeQuantityItem', 'CartController@changeQuantityItem');
Route::post('removeItem', 'CartController@removeItem');
Route::get('cancelCart', 'CartController@cancelCart');

//Latest
Route::any('latest/page/{page}', 'FrontendController@latest');
//Bestseller
Route::any('bestseller/page/{page}', 'FrontendController@bestSeller');
//search
Route::get('product/search/', 'FrontendController@search');

//detail cd
Route::get('product/detail/{id}/{name}', 'FrontendController@detailProduct');

//type
Route::any('product/type/{id}/{name}/{page}', 'FrontendController@type');
//Format
Route::any('product/format/{id}/{name}/{page}', 'FrontendController@format');

//view invoice
Route::get('view/invoices', 'FrontendController@viewInvoicePage');
Route::get('view/invoice/{id}', 'FrontendController@viewInvoice');

//checkout
Route::get('checkout', 'FrontendController@checkout');
Route::post('checkout-option', 'FrontendController@selectOptionCheckout');
Route::post('checkout-createDeliverDetail', 'FrontendController@createDeliverDetail');
Route::post('checkout-createDeliverMethod', 'FrontendController@createDeliverMethod');
Route::post('checkout-createPaymentMethod', 'FrontendController@createPaymentMethod');
//order
Route::post('order', 'FrontendController@order');
Route::post('order/listState', 'FrontendController@listState');
//


Route::get('account/doActive/{nameUser}/{keyActive}', 'AuthController@doActive');

Route::group(['middleware'=>'auth'],function(){
    Route::get('admin', 'BackendController@index');
//account
    Route::get('admin/account/list', 'AccountController@index');
    Route::post('admin/account/filterRole', 'AccountController@filterRole');

    Route::get('admin/account/create', 'AccountController@create');
    Route::post('admin/account/store', 'AccountController@store');
    Route::post('admin/account/remove', 'AccountController@destroy');
    Route::post('admin/account/update', 'AccountController@update');
    Route::post('/admin/account/getDataAjax','AccountController@getDataAjax');
    Route::post('/admin/account/getDataUser','AccountController@getDataUser');

    //Per
     Route::get('admin/permission/list', 'PermissionController@index');
     Route::post('admin/permission/createByAjax', 'PermissionController@createByAjax');
     Route::post('admin/permission/store', 'PermissionController@store');
    Route::post('admin/permission/getDataAjax','PermissionController@getDataAjax');
    Route::post('admin/permission/updateByAjax','PermissionController@updateByAjax');
    Route::post('admin/permission/updatePathByAjax','PermissionController@updatePathByAjax');
    Route::post('admin/permission/destroyByAjax','PermissionController@destroyByAjax');
    Route::post('admin/permission/checkPathByAjax','PermissionController@checkPathByAjax'); //Per

    //Role
     Route::get('admin/role/list', 'RoleController@index');
     Route::post('admin/role/createByAjax', 'RoleController@createByAjax');
     Route::post('admin/role/store', 'RoleController@store');
    Route::post('admin/role/getDataAjax','RoleController@getDataAjax');
    Route::post('admin/role/updateByAjax','RoleController@updateByAjax');
    Route::post('admin/role/destroyByAjax','RoleController@destroyByAjax');
    Route::post('admin/role/checkPathByAjax','RoleController@checkByAjax');

    // Order
    Route::get('admin/order-management','OrderController@index');
    Route::post('admin/getDataAjax','OrderController@getDataAjax');
    Route::post('admin/getDataAOrder','OrderController@getDataAOrder');
    Route::post('admin/changeStatus','OrderController@changeStatus');
    Route::post('admin/filterStatus','OrderController@filterStatus');
    //Navigator

    Route::get('admin/navigator/navigator-management', 'NavigatorController@index');
    Route::post('admin/navigator/createByAjax', 'NavigatorController@createByAjax');
    Route::post('admin/navigator/updateByAjax', 'NavigatorController@updateByAjax');
    Route::post('admin/navigator/checkPathByAjax', 'NavigatorController@checkPathByAjax');
    Route::post('admin/navigator/checkNameAjax', 'NavigatorController@checkNameByAjax');
    Route::post('admin/navigator/getDataForTree', 'NavigatorController@getDataForTree');
    Route::post('admin/navigator/getListPosition', 'NavigatorController@getListPosition');
    Route::post('admin/navigator/destroyByAjax','NavigatorController@destroyByAjax');
    Route::post('admin/navigator/listForDOM','NavigatorController@listForDOM');
    Route::post('admin/navigator/getDataNavigator','NavigatorController@getDataNavigator');

    //Artist admin/artists-management
    Route::get('admin/artist/artist-management', 'AttributeController@artist');
    Route::post('admin/artist/getDataAjax','ArtistController@getDataAjax');
    Route::post('admin/artist/getDataArtist','ArtistController@getDataArtist');
    Route::post('admin/artist/create','ArtistController@create');
    Route::post('admin/artist/update','ArtistController@update');
    Route::post('admin/artist/destroy','ArtistController@destroy');

    //type
    Route::get('admin/type/type-management', 'AttributeController@type');
    Route::post('admin/type/getDataAjax','TypeController@getDataAjax');
    Route::post('admin/type/create','TypeController@create');
    Route::post('admin/type/update','TypeController@update');
    Route::post('admin/type/destroy','TypeController@destroy');
    //FormatCD
    Route::get('admin/format-cd/format-cd-management', 'AttributeController@formatCD');
    Route::post('admin/format-cd/getDataAjax','FormatCDController@getDataAjax');
    Route::post('admin/format-cd/create','FormatCDController@create');
    Route::post('admin/format-cd/update','FormatCDController@update');
    Route::post('admin/format-cd/destroy','FormatCDController@destroy');
    //Price group
    Route::get('admin/price-group/price-group-management', 'AttributeController@priceGroup');
    Route::post('admin/price-group/getDataAjax','PriceGroupController@getDataAjax');
    Route::post('admin/price-group/create','PriceGroupController@create');
    Route::post('admin/price-group/update','PriceGroupController@update');
    Route::post('admin/price-group/destroy','PriceGroupController@destroy');

    //Cds
    Route::get('admin/product/product-management', 'ProductController@index');
    Route::post('admin/product/getDataAjax','ProductController@getDataAjax');
    Route::post('admin/product/getDataProduct','ProductController@getDataProduct');
    Route::post('admin/product/create','ProductController@create');
    Route::post('admin/product/update','ProductController@update');
    Route::post('admin/product/destroy','ProductController@destroy');
    Route::post('admin/product/searchSinger','ProductController@searchSinger');
    Route::post('admin/product/searchComposer','ProductController@searchComposer');
});
