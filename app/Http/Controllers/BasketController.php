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

	public function __construct()
	{
		$this->middleware('auth')->except([
			'add', 'remove', 'update', 'index'
		]);
	}

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
			'address' => 'required_if:choice,delivery',
			'registeredAddress' => 'required_if:address,existing',
			'street' => 'required_if:address,new',
			'city' => 'required_if:address,new',
			'zip' => 'required_if:address,new|numeric'
		]);

		session()->forget('delivery');

		if ($request->choice == 'pick-up') {
			session(['delivery.choice' => 'pick-up']);
		} else if ($request->address == 'new') {
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
		} else if ($request->address == 'existing') {
			$address = Address::find($request->registeredAddress);

			session([
				'delivery.choice' => 'delivery',
				'delivery.address' => $address->id
			]);
		}

		return redirect('/basket/payment');
	}

	public function paymentForm()
	{
		if (session('delivery.choice') == 'delivery')
			$address = Address::find(session('delivery.address'));
		else
			$address = null;

		return view('basket.payment')->withAddress($address);
	}
}
