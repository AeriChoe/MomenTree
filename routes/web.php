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
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/user/{id}', 'HomeController@user')->middleware('auth');
Route::get('/mypage', 'HomeController@mypage')->middleware('auth');

Route::post('/search', 'PostController@search')->middleware('auth');
Route::get('/post', 'PostController@post')->middleware('auth');
Route::get('/nocate', 'PostController@nocate');
Route::get('/profile', 'ProfileController@profile')->middleware('auth');
Route::get('/category', 'CategoryController@category')->middleware('auth');
Route::post('/addCategory', 'CategoryController@addcategory');
Route::get('/deleteCategory/{id}', 'CategoryController@deleteCategory');
Route::post('/addProfile', 'ProfileController@addProfile')->middleware('auth');
Route::get('/editPro/{id}', 'ProfileController@editPro')->middleware('auth');
Route::post('/editProfile/{id}', 'ProfileController@editProfile')->middleware('auth');
Route::post('/addPost', 'PostController@addPost')->middleware('auth');

Route::get('/view/{id}', 'PostController@view')->middleware('auth');

Route::get('/edit/{id}', 'PostController@edit')->middleware('auth');
Route::post('/editPost/{id}', 'PostController@editPost')->middleware('auth');
Route::get('/delete/{id}', 'PostController@deletePost')->middleware('auth');
Route::get('/category/{id}', 'PostController@category');
Route::get('/like/{id}', 'HomeController@like')->middleware('auth');
Route::get('/dislike/{id}', 'HomeController@dislike')->middleware('auth');
Route::post('/comment/{id}', 'PostController@comment')->middleware('auth');

Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider2');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback2');

Route::get('login/google', 'Auth\LoginController@redirectToProvider3');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback3');
