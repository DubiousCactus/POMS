<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/orders/new', 'APIController@newOrders');
Route::middleware('auth:api')->patch('/orders/{id}/confirm', 'APIController@confirmOrder');

Route::middleware('auth:api')->get('/addresses/{id}', 'APIController@getAddress');

