<?php

namespace Tests\Feature;

use Auth;
use App\Item;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MakeOrderTest extends TestCase
{
	use DatabaseTransactions;

    /**
	 * Order creation test
     *
     * @return void
     */
    public function testMakeOrder()
	{
		/* Creating basic user */
		$user = factory(User::class)->create();

		/* Guest user must get access */
		$response = $this->actingAs(User::guest())->get('/');
		$response->assertStatus(200);

		/* Pick item from category allowing toppings */
		$itemWithToppings = Category::all()->first(function ($value) {
			return $value->hasToppings();
		})->items()->random();

		/* Pick item from category disallowing toppings */
		$itemWithoutToppings = Category::all()->first(function ($value) {
			return !$value->hasToppings();
		})->items()->random();

		/* Add to basket: with topping */
		$toppings = Topping::random(3)->toArray();

		/* Guest user allowed */
		/* Add with topping in category allowing toppings */
		$response = addToBasket($itemWithToppings, $toppings); 
		$response->assertStatus(200);
		$response->assertSessionMissing('error');

		/* Add with topping in category disallowing toppings */
		$response = addToBasket($itemWithoutToppings, $toppings);
		$response->assertSessionHas('error');

		/* Add without topping in category allowing toppings */
		$response = addToBasket($itemWithToppings);
		$response->assertStatus(200);
		$response->assertSessionMissing('error');

		/* Add item with a negative quantity */
		$response = addToBasket($itemWithoutToppings, null, -1);
		$response->assertSessionHas('error'); //Forbidden

		/* Confirm order and get delivery form */
		/* Guest user musn't be allowed */
		$response = $this->post('/order/confirm');
		$response->assertStatus(302); //Be redirected to login page
		$response->assertSessionHas('error');

		/* Logged in user must not be allowed if his cart is empty */
		$response = $this->actingAs($user)->post('/order/confirm');
		$response->assertSessionHas('error'); //Forbidden

		/* Logged in user must be allowed if his cart is not empty */
		$response = $this->actingAs($user)
			->withSession([
				'cart' => true
		])->get('/order/confirm');
		$response->assertStatus(302); //Be Redirected to delivery form
		$response->assertSessionMissing('error');
		$response->assertViewHas($order);
	}

	private function addToBasket($item, $toppings = null, $qty = 1) 
	{
		return $this->json->('POST', '/order', [
			'item' => $item,
			'quantity' => $qty,
			//'size' => Size::random(),
			'toppings' => $toppings
		]);
	}
}
