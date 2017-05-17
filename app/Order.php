<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use LaravelCustomRelation\HasCustomRelations;

class Order extends Model
{
	use HasCustomRelations;

    protected $fillable = [
    	'processed', 'waiting_time', 'address_id', 'user_id'
	];

	public function itemToppingPivots()
	{
		return $this->belongsToMany(ItemToppingPivot::class, 'order_item_topping',
			'order_id', 'item_topping_id');
	}

	public function items()
	{
		$items = collect();

		$this->itemToppingPivots->each(function($pivot, $key) use(&$items) {
			if (!$items->has($pivot->item->id))
				$items->put($pivot->item->id,
					$pivot->item
						->setQuantity($pivot->quantity)
						->setSize($pivot->size)
				);
		});

		return $items;
	}

	public function address()
	{
		return $this->belongsTo(Address::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

}
