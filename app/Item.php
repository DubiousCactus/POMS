<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
    	'name', 'ingredients', 'price'
    ];

    public function toppings()
    {
    	return $this->belongsToMany(Topping::class, 'item_topping')->withTimeStamps();
    }
}
