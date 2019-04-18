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

Route::get('/post', 'PostController@post');
Route::get('/nocate', 'PostController@nocate');
Route::get('/profile', 'ProfileController@profile');
Route::get('/category', 'CategoryController@category');
Route::post('/addCategory', 'CategoryController@addcategory');
Route::get('/deleteCategory/{id}', 'CategoryController@deleteCategory');
Route::post('/addProfile', 'ProfileController@addProfile');
Route::get('/editPro/{id}', 'ProfileController@editPro');
Route::post('/editProfile/{id}', 'ProfileController@editProfile');
Route::post('/addPost', 'PostController@addPost');

Route::get('/view/{id}', 'PostController@view');
Route::get('/edit/{id}', 'PostController@edit');
Route::post('/editPost/{id}', 'PostController@editPost');
Route::get('/delete/{id}', 'PostController@deletePost');
Route::get('/category/{id}', 'PostController@category');
Route::get('/like/{id}', 'PostController@like');
Route::get('/dislike/{id}', 'PostController@dislike');

Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider2');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback2');

Route::get('login/google', 'Auth\LoginController@redirectToProvider3');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback3');
