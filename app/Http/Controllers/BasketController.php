<?php

namespace App\Http\Controllers;

use App\Item;
use App\Size;
use App\Topping;
use App\Facades\Cart;
use Illuminate\Http\Request;
use App\Http\Requests\AddToBasketRequest;

class BasketController extends Controller
{
	public function add(AddToBasketRequest $request)
	{
		$item = Item::find($request->item);
		$size = isset($request->size) ? Size::find($request->size) : null;
		$toppings = null;

		if (isset($request->toppings)) {
			$toppings = array();

			foreach ($request->toppings as $toppingId)
				array_push($toppings, Topping::find($toppingId));
		}

		Cart::add($item, $size, $toppings);
		
		return response('success', 200);
	}

	public function remove(Request $request)
	{
		Cart::remove($request->hash);

		return back();
	}

	public function index()
	{
		return view('basket');
	}
}
