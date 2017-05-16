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
Route::get('/manage/items/{item}/edit', 'ItemsController@edit');
Route::patch('/manage/items/{item}', 'ItemsController@update');
Route::delete('/manage/toppings/{topping}', 'ToppingsController@destroy');
Route::get('/manage/toppings/{topping}/edit', 'ToppingsController@edit');
Route::patch('/manage/toppings/{topping}', 'ToppingsController@update');

Route::resource('/order', 'OrdersController');

Route::post('/basket', 'BasketController@add');
Route::get('/basket', 'BasketController@index');
Route::delete('/basket/{hash}', 'BasketController@remove');
Route::patch('/basket/{hash}', 'BasketController@update');

Route::get('/basket/destroy', function() {
	Cart::destroy();
});
