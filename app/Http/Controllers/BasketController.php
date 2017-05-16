<?php

namespace App\Http\Controllers;

use Auth;
use App\Item;
use App\Size;
use App\Address;
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

	public function update($hash, Request $request)
	{
		$this->validate($request, [
			'quantity' => 'required|numeric|min:1'
		]);

		Cart::setQuantity($hash, $request->quantity);

		return response('success', 200);
	}

	public function index()
	{
		return view('basket.index');
	}

	public function deliveryForm()
	{
		return view('basket.delivery');
	}

	public function delivery(Request $request)
	{
		$this->validate($request, [
			'choice' => 'required',
			'street' => 'required_if:choice,delivery',
			'city' => 'required_if:choice,delivery',
			'zip' => 'required_if:choice,delivery|numeric'
		]);

		if ($request->choice == 'delivery') {
			$address = Address::make([
				'street' => $request->street,
				'city' => $request->city,
				'zip' => $request->zip
			]);

			$address = Auth::user()->addresses()->save($address);

			session([
				'delivery.choice' => 'delivery',
				'delivery.address' => $address->id
			]);
		} else {
			session(['delivery.choice' => 'pick-up']);
		}

		return redirect('/basket/payment');
	}

	public function paymentForm()
	{
		return view('basket.payment');
	}
}
