<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Item;
use Illuminate\Http\Request;

class BasketController extends Controller
{
	public function add(Request $request)
	{
		//TODO: Validate request (create custom request)
		$item = Item::find($request->itemId);
		$qty = $request->qty;

		Cart::add($item, $qty);
		
		return back()->with('success', true);
	}

	public function index()
	{
		return view('basket');
	}
}
