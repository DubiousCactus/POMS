<?php

namespace App;

use Illuminate\Support\Collection;

class Cart
{
	private $items; //Collection of CartItem

	public function __construct()
	{
		$this->items = collect();
	}

	public function add(Item $item, int $qty) //, Size $size)
	{
		$this->items->push(new CartItem($item, $qty));

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
}
