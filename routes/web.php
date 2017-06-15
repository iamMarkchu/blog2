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

//back
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth']], function(){
   Route::get('/', function(){
      return view('admin/home');
   });
   Route::resource('category', 'CategoryController');
   Route::resource('tag', 'TagController');
   Route::resource('article', 'ArticleController');
   Route::put('article/{id}/status', 'ArticleController@status');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//front
Route::get('/', 'PageController@home');
Route::get('article/{id}.html', 'PageController@article')->name('article');