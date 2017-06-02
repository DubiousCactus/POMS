<?php

namespace Tests\Feature;

use Faker\Factory;
use Auth;
use App\Item;
use App\Size;
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

		/* Creating basic user who is shopping */
		$user = factory(User::class)->create();

		/* Creating basic user who is not shopping (empty cart) */
		$uselessUser = factory(User::class)->create();

		/* Creating dummy items / categories / sizes */
		$categoryWithToppings = factory(Category::class)->make();
		$categoryWithToppings->has_toppings = true;
		$categoryWithToppings->save();

		$categoryWithoutToppings = factory(Category::class)->create(); //has_toppings = false by default
		
		factory(Item::class, 3)->make()->each(function ($value, $key) use(&$categoryWithToppings) {
			$categoryWithToppings->items()->save($value);
		});

		factory(Item::class, 3)->make()->each(function ($value, $key) use(&$categoryWithoutToppings) {
			$categoryWithoutToppings->items()->save($value);
		});

		factory(Topping::class, 3)->create();

		$size = factory(Size::class)->create();

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
		$toppings = Topping::all()->random(3);

		/* Guest user allowed */
		/* Add with topping in category allowing toppings */
		$response = $this->addToBasket($user, $itemWithToppings, $size, $toppings); 
		$response->assertStatus(200);

		/* Add with topping in category disallowing toppings */
		$response = $this->addToBasket($user, $itemWithoutToppings, $size, $toppings);
		$response->assertStatus(422);

		/* Add without topping in category allowing toppings */
		$response = $this->addToBasket($user, $itemWithToppings, $size);
		$response->assertStatus(200);

		/* Confirm order and get delivery form */
		/* Guest user musn't be allowed */
		$response = $this->get('/basket/delivery');
		$response->assertStatus(302); //Be redirected to login page
		$response->assertHeader('location', url('/') . '/login');

		/* Logged in user must not be allowed if his cart is empty */
		$response = $this->actingAs($uselessUser)->get('/basket/delivery');
		$response->assertSessionHas('error'); //Forbidden

		/* Logged in user must be allowed if his cart is not empty */
		$response = $this->actingAs($user)->get('/basket/delivery');
		$response->assertStatus(200);

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

	private function addToBasket($user, $item, $size, $toppings = null) 
	{
		$toppingsIds = array();

		if ($toppings) {
			$toppings->each(function($topping) use(&$toppingsIds) {
				array_push($toppingsIds, $topping->id);
			});
		}

		$response =  $this->actingAs($user)->json('POST', '/basket', [
			'item' => $item->id,
			'size' => $size->id,
			'toppings' => $toppingsIds
		]);

		return $response;
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
