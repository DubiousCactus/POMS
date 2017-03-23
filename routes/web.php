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

Auth::routes();

Route::get('/', 'PagesController@index');
Route::get('/manage', 'PagesController@manage');
Route::get('/manage/items', 'PagesController@manageMenu');
Route::get('/manage/toppings', 'PagesController@manageToppings');
Route::get('/manage/items/add', 'ItemsController@create');
Route::get('/manage/toppings/add', 'ToppingsController@create');
Route::put('/manage/items', 'ItemsController@store');
Route::put('/manage/toppings', 'ToppingsController@store');
Route::delete('/manage/items/{item}', 'ItemsController@destroy');
