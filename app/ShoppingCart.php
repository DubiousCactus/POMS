<?php

namespace App;

use Illuminate\Support\Collection;

class ShoppingCart
{
	private $items; //Collection of CartItem

	public function __construct()
	{
		if (session()->has('ShoppingCart.items')) {
			$this->items = session('ShoppingCart.items');
		} else {
			$this->items = collect();
			session(['ShoppingCart.items' => $this->items]);
		}
	}

	public function add(Item $item, Size $size = null, array $toppings = null)
	{
		$newItem = new CartItem($item, $size, $toppings);
		$this->items->put($newItem->getHash(), $newItem);

		return $this->items;
	}

	public function remove($hash)
	{
		return $this->items->forget($hash);
	}

	public function setQuantity($hash, int $qty)
	{
		return $this->items->get($hash)->setQuantity($qty);
	}
   
	public function all()
	{
		return $this->items;
	}

	public function count()
	{
		return $this->items->count();
	}

	public function destroy()
	{
		$this->items = collect();
		
		session()->flush();

		return $this->items;
	}

	public function total()
	{
		$total = 0;

		$this->items->each(function($cartItem) use(&$total) {
			$total += floatval($cartItem->getTotalPrice());
		});

		return $total;
	}
}
