<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	public $quantity = null;
	public $size = null;

    protected $fillable = [
    	'name', 'ingredients', 'price'
    ];

    public function toppings()
    {
    	return $this->belongsToMany(Topping::class, 'item_topping')->withTimeStamps();
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function isPizza()
	{
		return $this->category->has_toppings;
	}

	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;

		return $this;
	}

	public function setSize($size)
	{
		$this->size = $size;

		return $this;
	}
}

