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

Route::domain('admin.eleb.com')->group(function () {
    Route::namespace('Admin')->group(function (){
        Route::resource('shop_categories','ShopCategoryController');
        Route::resource('shops','ShopController');
    });
    Route::get('login',function(){})->name('login');
    Route::get('logout',function(){})->name('logout');
});



Route::domain('shop.eleb.com')->group(function () {

});


Route::domain('www.eleb.com')->group(function () {

});
