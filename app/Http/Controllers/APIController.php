<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class APIController extends Controller
{
	public function newOrders()
	{
		return Order::where(['confirmed' => false])->get()->toJson();
	}

	public function confirmOrder(Request $request, $id)
	{
		$this->validate($request, [
			'confirmed' => 'required'
		]);

		Order::find($id)->update(['confirmed' => $request->confirmed]);

		return response('Success', 200);
	}

	public function show(Order $order)
	{

	}
}
