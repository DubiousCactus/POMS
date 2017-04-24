<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['name', 'has_toppings'];

	public function items()
	{
		return $this->hasMany(Item::class);
	}
}
