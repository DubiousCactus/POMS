<?php

namespace Tests\Unit;

use App\User;
use App\Topping;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ToppingTest extends TestCase
{
	/*
	 * Topping creation test.
	 */
	public function testCreateTopping()
	{
		/* First we create an admin user */
		$adminUser = factory(User::class)->make();
		$adminUser->is_admin = true;
		$adminUser->save();

		/* Then a dummy basic user */
		$user = factory(User::class)->create();

		/* Test: adminUser must get access */
		$response = $this->actingAs($adminUser)->get('/manage/toppings/add');
		$response->assertStatus(200);

		/* Test: user must not get access */
		$response = $this->actingAs($user)->get('/manage/toppings/add');
		$response->assertSessionHas('error');

		$adminTopping = factory(Topping::class)->make();
		
		/* Create topping as administrator */
		$response = $this->actingAs($adminUser)
			->json('POST', route('topping.store'), [
				'name' => $adminTopping->name,
				'price' => $adminTopping->price
			]);
		
		$response->assertStatus(302); //Created successfuly, redirected

		/* Create topping as basic user */
		$topping = factory(Topping::class)->make();

		$response = $this->actingAs($user)
			->json('POST', route('topping.store'), [
				'name' => $topping->name,
				'price' => $topping->price
		]);

		$response->assertSessionHas('error'); //Forbidden

		/* Assert the database for the adminTopping, because the basic user should receive a 302 */	
    	$this->assertDatabaseHas('toppings', [
	        'name' => $adminTopping->name,
    		'price' => $adminTopping->price 
	    ]);
	}
	
	/*
	 * Topping deletion test.
	 */
	public function testDeleteTopping()
	{
		/* Create dummy topping to be deleted */
		$topping = factory(Topping::class)->create();

		/* Create basic user */
		$user = factory(User::class)->create();

		/* Create admin user */
		$adminUser = factory(User::class)->make();
		$adminUser->is_admin = true;
		$adminUser->save();

		/* Basic user shouldn't get access to the admin panel */
		$response = $this->actingAs($user)->get('/manage/toppings');
		$response->assertSessionHas('error'); //Forbidden

		/* Admin user should get access to the admin panel */
		$response = $this->actingAs($adminUser)->get('/manage/toppings');
		$response->assertStatus(200); //Okay

		/* Basic user shouldn't be able to delete the topping */
		$response = $this->actingAs($user)->json('DELETE', route('topping.destroy', ['topping' => $topping]), []);
		$response->assertSessionHas('error'); //Forbidden

		/* Admin user should be able to delete the topping */
		$response = $this->actingAs($adminUser)->json('DELETE', route('topping.destroy', ['topping' => $topping]), []);
		$response->assertStatus(302); //Redirected but okay
		$response->assertSessionMissing('error');

		/* Make sure it has been deleted from the database */
		$this->assertDatabaseMissing('toppings', [
			'name' => $topping->name,
			'price' => $topping->price
		]);
	}

	/*
	 * Topping modification test.
	 */
	public function testUpdateTopping()
	{
		/* Create dummy item to be deleted */
		$topping = factory(Topping::class)->create();

		/* Create basic user */
		$user = factory(User::class)->create();

		/* Create admin user */
		$adminUser = factory(User::class)->make();
		$adminUser->is_admin = true;
		$adminUser->save();

		/* Basic user shouldn't get access to the admin panel */
		$response = $this->actingAs($user)->get('/manage/toppings/' . $topping->id . '/edit');
		$response->assertSessionHas('error'); //Forbidden

		/* Admin user should get access to the admin panel */
		$response = $this->actingAs($adminUser)->get('/manage/toppings/' . $topping->id . '/edit');
		$response->assertStatus(200); //Okay

		/* Basic user shouldn't be able to update the topping */
		$response = $this->actingAs($user)
			->json('PATCH', route('topping.update', ['topping' => $topping]), [
				'name' => 'Another name',
				'price' => 0	
			]);
		$response->assertSessionHas('error'); //Forbidden

		/* Admin user should be able to update the topping */
		$response = $this->actingAs($adminUser)
			->json('PATCH', route('topping.update', ['topping' => $topping]), [
				'name' => 'Another different name',
				'price' => 0.5
			]);
		$response->assertStatus(302); //Redirected but okay
		$response->assertSessionMissing('error');

		/* Make sure the previous values are missing from the database */
		$this->assertDatabaseMissing('toppings', [
			'name' => $topping->name,
			'price' => $topping->price
		]);

		/* Make sure the basic user's modifications are missing from the database */
		$this->assertDatabaseMissing('toppings', [
			'name' => 'Another name',
			'price' => 0
		]);

		/* Make sure the admin user's modifications are present in the database */
		$this->assertDatabaseHas('toppings', [
			'name' => 'Another different name',
			'price' => 0.5
		]);
	}
}
