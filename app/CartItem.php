<?php

namespace App;

class CartItem
{
	private $item;
	private $quantity;
	private $size;
	private $toppings;
	private $hash;
	
	public function __construct(Item $item, Size $size = null, array $toppings = null)
	{
		$this->item = $item;
		$this->quantity = 1;
		$this->size = $size;
		$this->toppings = $toppings;
		$this->hash = spl_object_hash($this);
	}

	public function getItem() : Item
	{
		return $this->item;
	}

	public function getQuantity() : int
	{
		return $this->quantity;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function getToppings()
	{
		return $this->toppings;
	}

	public function setQuantity(int $qty)
	{
		$this->quantity = $qty;
	}

	public function getHash()
	{
		return $this->hash;
	}

	public function isPizza()
	{
		return $this->item->isPizza();
	}
}
