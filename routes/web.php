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

/* Items */
Route::resource('item', 'ItemsController', ['except' => [
	'index', 'edit', 'create'
]]);

/* Toppings */
Route::resource('topping', 'ToppingsController', ['except' => [
	'index', 'edit', 'create'
]]);

/* Orders */
Route::resource('order', 'OrdersController', ['except' => [
	'index', 'edit', 'create'
]]);

/* Admin interface */
Route::get('/manage', 'PagesController@manage');
Route::get('/manage/items', 'PagesController@manageMenu');
Route::get('/manage/toppings', 'PagesController@manageToppings');
Route::get('/manage/items/add', 'ItemsController@create');
Route::get('/manage/toppings/add', 'ToppingsController@create');
Route::get('/manage/items/{item}/edit', 'ItemsController@edit');
Route::get('/manage/toppings/{topping}/edit', 'ToppingsController@edit');

/* Basket */
Route::post('/basket', 'BasketController@add');
Route::get('/basket', 'BasketController@index');
Route::delete('/basket/{hash}', 'BasketController@remove');
Route::patch('/basket/{hash}', 'BasketController@update');
Route::get('/basket/delivery', 'BasketController@deliveryForm');
Route::post('/basket/delivery', 'BasketController@delivery');
Route::get('/basket/payment', 'BasketController@paymentForm');
Route::post('/basket/purchase', 'BasketController@purchase');

/* Testing */
Route::get('/basket/destroy', function() {
	Cart::destroy();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
