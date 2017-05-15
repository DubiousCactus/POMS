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

	public function add(Item $item, int $qty) //, Size $size)
	{
		$newItem = new CartItem($item, $qty);
		$this->items->push($newItem);

		return $this->items;
	}

	public function remove()
	{
		return $this->items;
	}

	public function setQuantity(int $qty)
	{
		return $this;
	}
   
	public function all()
	{
		return $this->items->all();
	}

	public function count()
	{
		return $this->items->count();
	}

	public function destroy()
	{
		$this->items = collect();
		session(['ShoppingCart.items' => $this->items]);

		return $this->items;
	}

	public function total()
	{
		$total = 0;

		$this->items->each(function($cartItem) use(&$total) {
			$total += floatval($cartItem->getItem()->price);
		});

		return $total;
	}
}
