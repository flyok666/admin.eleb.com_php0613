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

        Route::get('login','SessionController@login')->name('login');
        Route::get('logout','SessionController@logout')->name('logout');
        Route::get('register','SessionController@register')->name('register');


        //文件上传
        Route::post('upload','ShopCategoryController@upload')->name('upload');

    });

});



Route::domain('shop.eleb.com')->group(function () {

});


Route::domain('www.eleb.com')->group(function () {

});
