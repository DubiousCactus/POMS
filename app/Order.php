<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    	'processed', 'waiting_time'
    ];

    public function items()
    {
    	$relation = $this->belongsToMany(Item::class)
    		->withPivot('order_item_topping', 'quantity', 'size');

    	$relation->getQuery()
    		->join('item_topping', 'order_item_topping.item_topping_id', '=', 'item_topping.id')
    		->select('item_topping.item_id')
    		->group_by('item_topping.item_id');

    	return $relation;
    }

    public function toppings()
    {
    	return $this->hasManyThrough(Topping::class, Item::class);
    }
}
