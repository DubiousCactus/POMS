<?php

namespace App\Http\Requests\Validators;

use App\Item;
use App\Topping;
use App\Category;

class ToppingsValidator
{

	public function validate($attribute, $value, $parameters, $validator)
	{
		$category = Item::find($validator->getData()['item'])->category;
		
		if (!is_array($value) || !$category->has_toppings)
			return false;

		foreach ($value as $toppingId) {
			if (Topping::find($toppingId) == null)
				return false;
		}

		return true;
	}
}
