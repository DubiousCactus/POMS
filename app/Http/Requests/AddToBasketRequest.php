<?php

namespace App\Http\Requests;

use App\Item;
use Illuminate\Foundation\Http\FormRequest;

class AddToBasketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
			'item' => 'required|numeric|exists:items,id',
			'size' => 'sometimes|numeric|exists:sizes,id',
		];

		$inputs = $this->all();

		if (isset($inputs['toppings'])) {
			
			if (!Item::find($inputs['item'])->category->has_toppings) {
				unset($inputs['toppings']);
				$this->replace($inputs);
			} else {
				foreach ($inputs['toppings'] as $index => $value)
					$rules['toppings' . $index] = 'exists:toppings,id';
			}
		}

		return $rules;
    }
}
