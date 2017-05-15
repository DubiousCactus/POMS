<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Item;
use Illuminate\Http\Request;
use App\Http\Requests\AddToBasketRequest;

class BasketController extends Controller
{
	public function add(AddToBasketRequest $request)
	{
		$item = Item::find($request->item);
		$size = Size::find($request->size);
		$toppings = $request->toppings;

		Cart::add($item, $size, $toppings);
		
		return back()->with('success', true);
	}

	public function index()
	{
		return view('basket');
	}
}
