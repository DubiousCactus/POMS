<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemToppingPivot extends Model
{
	protected $table = 'item_topping';

	protected $fillable = [
		'item_id', 'topping_id'
	];

	public function item()
	{
		return $this->belongsTo(Item::class);
	}

	public function topping()
	{
		return $this->belongsTo(Topping::class);
	}

	public function orders()
	{
		return $this->belongsToMany(Order::class, 'order_item_topping',
			'item_topping_id', 'order_id');
	}
}
