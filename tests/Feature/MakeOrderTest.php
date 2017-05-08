<?php

namespace Tests\Feature;

use Faker\Factory;
use Auth;
use App\Item;
use App\User;
use App\Topping;
use App\Category;
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
		$faker = Factory::create();

		/* Creating basic user */
		$user = factory(User::class)->create();

		/* Creating dummy items / categories */
		$categoryWithToppings = factory(Category::class)->make();
		$categoryWithToppings->has_toppings = true;
		$categoryWithToppings->save();

		$categoryWithoutToppings = factory(Category::class)->create();
		
		factory(Item::class, 3)->make()->each(function ($value, $key) use($categoryWithToppings) {
			$categoryWithToppings->items()->save($value);
		});
		factory(Item::class, 3)->make()->each(function ($value, $key) use($categoryWithoutToppings) {
			$categoryWithoutToppings->items()->save($value);
		});

		/* Guest user must get access */
		$response = $this->get('/');
		$response->assertStatus(200);

		/* Pick item from category allowing toppings */
		$itemWithToppings = Category::where('has_toppings', true)
			->get()->random()->items()->get()->random();

		/* Pick item from category disallowing toppings */
		$itemWithoutToppings = Category::where('has_toppings', false)
			->get()->random()->items()->get()->random();

		/* Add to basket: with topping */
		$toppings = Topping::all()->random(3)->toArray();

		/* Guest user allowed */
		/* Add with topping in category allowing toppings */
		$response = $this->addToBasket($itemWithToppings, $toppings); 
		$response->assertStatus(200);
		$response->assertSessionMissing('error');

		/* Add with topping in category disallowing toppings */
		$response = $this->addToBasket($itemWithoutToppings, $toppings);
		$response->assertSessionHas('error');

		/* Add without topping in category allowing toppings */
		$response = $this->addToBasket($itemWithToppings);
		$response->assertStatus(200);
		$response->assertSessionMissing('error');

		/* Add item with a negative quantity */
		$response = $this->addToBasket($itemWithoutToppings, null, -1);
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
		$response->assertViewHas('order');

		/* Submit delivery form */
		/* Guest user must not be allowed */
		$response = $this->post('/delivery/submit/');
		$response->assertSessionHas('error');

		/* Logged in user must not be allowed if he doesn't have any confirmed order */
		$response = $this->submitDelivery();
		$response->assertSessionHas('error');

		/* Logged in user must be allowed if he has a confirmed order */
		$response = $this->submitDelivery($user);
		$response->assertSessionMissing('error');
		$response->assertViewHas('order');

		/* Submit payment form */
		/* Guest user must not be allowed */
		$response = $this->post('/order/purchase');
		$response->assertSessionHas('error');

		/* Logged in user must not be allowed if he doesn't have any confirmed order */
		$response = $this->submitPayment($user); 
		/* Logged in user must be allowed if he has a confirmed order */
		$response = $this->submitPayment($user);
		$response->assertStatus(302); //Redirected to confirmation / error page
		$response->assertSessionMissing('error');
		$response->assertViewHas('confirmationNumber');
	}

	private function addToBasket($item, $toppings = null, $qty = 1) 
	{
		return $this->json('POST', '/order', [
			'items' => [
				[
					'item' => $item,
					'quantity' => $qty,
					//'size' => Size::random(),
					'toppings' => $toppings
				],
				[
					'item' => $item,
					'quantity' => 1,
					//'size' => Size::random(),
					'toppings' => null
				]
			]
		]);
	}

	private function submitDelivery($user = null)
	{
		return  $this->actingAs($user)
			->json('post', '/delivery/submit', [
				'delivery' => true,
				'street' => $faker->address(),
				'city' => $faker->city(),
				'zip' => $faker->number()
			]);
	}

	private function submitPayment($user = null)
	{
		return $this->actingAs($user)
			->withSession([
				'order' => true
			])->json('post', '/order/purchase', [
				'credit_card' => true,
				'number' => $faker->number(),
				'name' => $faker->name(),
				'expiry_date' => $faker->date(),
				'cvr' => $faker->number()
			]);
	}
}
