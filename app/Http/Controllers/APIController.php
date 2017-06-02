<?php

namespace App\Http\Controllers;

use App\Order;
use App\Address;
use Illuminate\Http\Request;

class APIController extends Controller
{
	public function newOrders()
	{
		$orders = Order::unconfirmed();
		$ordersJson = $orders->toJson();
		$ordersJsonArray = json_decode($ordersJson);
		
		$orders->each(function($orderValue, $orderKey) use(&$ordersJsonArray) {
			$orderValue->items->each(function($value, $key) use(&$ordersJsonArray, $orderKey) {
				unset($ordersJsonArray[$orderKey]->item_topping_pivots);
				unset($ordersJsonArray[$orderKey]->updated_at);
				unset($ordersJsonArray[$orderKey]->processed);
				unset($ordersJsonArray[$orderKey]->waiting_time);
				unset($ordersJsonArray[$orderKey]->confirmed);

				$itemsArray = array();
				
				foreach($ordersJsonArray[$orderKey]->items as $item) {
					$toppingNames = array();

					$value->toppings->each(function($topping) use(&$toppingNames) {
						array_push($toppingNames, $topping->name);
					});

					$item->quantity = $value->quantity;
					$item->size = $value->size->name;
					$item->toppings = $toppingNames;

					unset($item->created_at);
					unset($item->updated_at);
					unset($item->id);
					unset($item->price);
					unset($item->category_id);
					array_push($itemsArray, $item);
				}

				unset($ordersJsonArray[$orderKey]->items);
				$ordersJsonArray[$orderKey]->items = $itemsArray;
			});
		});

		return json_encode($ordersJsonArray);
	}

	public function confirmOrder(Request $request, $id)
	{
		$this->validate($request, [
			'confirmed' => 'required',
			'waiting_time' => 'required|numeric'
		]);

		Order::find($id)->update([
			'confirmed' => $request->confirmed,
			'waiting_time' => $request->waiting_time
		]);

		return response('Success', 200);
	}

	public function getAddress($id)
	{
		return Address::find($id)->toJson();
	}

	public function show(Order $order)
	{

	}
}
