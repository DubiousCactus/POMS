<?php

namespace App;

class CartItem
{
	private $item;
	private $quantity;
	private $size;
	
	public function __construct(Item $item, int $qty) //, Size $size)
	{
		$this->item = $item;
		$this->quantity = $qty;
		//$this->size = $size;
	}

	public function getItem() : Item
	{
		return $this->item;
	}

	public function getQuantity() : int
	{
		return $this->quantity;
	}

	public function getSize() : Size
	{
		return $this->size;
	}

	public function setQuantity(int $qty)
	{
		$this->quantity = $qty;
	}

	public function setSize(Size $size)
	{
		$this->size = $size;
	}
}
