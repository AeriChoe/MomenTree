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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'inquiry', 'as' => 'inquiry', 'middleware' => 'forceSsl'], function(){ // https
    Route::get('/', 'InquiryController@index');
    Route::post('/store', 'InquiryController@store');
    Route::get('/finish', 'InquiryController@finish');
});
