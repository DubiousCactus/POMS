<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use LaravelCustomRelation\HasCustomRelations;

class Order extends Model
{
	use HasCustomRelations;

    protected $fillable = [
    	'processed', 'waiting_time', 'address_id', 'user_id', 'confirmed'
	];

	public function itemToppingPivots()
	{
		return $this->belongsToMany(ItemToppingPivot::class, 'order_item_topping',
					'order_id', 'item_topping_id')
					->withPivot('quantity', 'size_id');
	}

	public function items()
	{
		$items = collect();

		$this->itemToppingPivots->each(function($itemWithTopping, $key) use(&$items) {
			if (!$items->has($itemWithTopping->item->id))
				$items->put($itemWithTopping->item->id,
					$itemWithTopping->item
						->setQuantity($itemWithTopping->pivot->quantity)
						->setSize(Size::find($itemWithTopping->pivot->size_id))
				);
		});

		return $items;
	}

	/*
	 * Override $order->items
	 */
	public function getItemsAttribute()
	{
		return $this->items();
	}

	public function address()
	{
		return $this->belongsTo(Address::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public static function unconfirmed()
	{
		$orders = Order::where(['confirmed' => false])->get();

		$orders->each(function($value, $key) {
			$value->items = $value->items();
		});

		return $orders;
	}

}
