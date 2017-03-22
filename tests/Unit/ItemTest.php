<?php

namespace Tests\Unit;

use App\Item;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{
	use DatabaseTransactions;
	
    /**
	 * Item creation test. User must be connected, and must be admin.
	 *
     * @return void
     */
    public function testCreateItem()
	{
		/* First we create an admin user */
		$adminUser = factory(User::class)->make();
		$adminUser->is_admin = true;
		$adminUser->save();

		/* Then a dummy basic user */
		$user = factory(User::class)->create();

		/* Test: adminUser must get access */
		$response = $this->actingAs($adminUser)->get('/manage/items/add');
		$response->assertStatus(200);

		/* Test: user must not get access */
		$response = $this->actingAs($user)->get('/manage/items/add');
		$response->assertStatus(302);

		$adminItem = factory(Item::class)->make();
		
		/* Create item as administrator */
		$response = $this->actingAs($adminUser)
			->json('PUT', '/manage/items', [
				'name' => $adminItem->name,
				'ingredients' => $adminItem->ingredients,
				'price' => $adminItem->price
			]);
		
		$response->assertStatus(302); //Created successfuly

		/* Create item as basic user */
		$item = factory(Item::class)->make();

		$response = $this->actingAs($user)
			->json('PUT', '/manage/items', [
				'name' => $item->name,
				'ingredients' => $item->ingredients,
				'price' => $item->price
		]);

		$response->assertStatus(302); //Forbidden

		/* Assert the database for the adminItem, because the basic user should receive a 302 */	
    	$this->assertDatabaseHas('items', [
	        'name' => $adminItem->name,
    		'ingredients' => $adminItem->ingredients,
    		'price' => $adminItem->price 
	    ]);
	}

	/*
	 * Items index test. Creates and inserts 3 items in the database. Creates one
	 * but doesn't insert it. Checks that only the inserted ones are present in the view.
	 */
	public function testGetItemsIndex()
	{
		$item1 = factory(Item::class)->create();
		$item2 = factory(Item::class)->create();
		$item3 = factory(Item::class)->create();
		$item4 = factory(Item::class)->make(); //Don't insert this one

		$response = $this->get('/');
		$view = $response->original; //Get the view from the landing page

		$this->assertTrue($view['items']->contains($item1));
		$this->assertTrue($view['items']->contains($item2));
		$this->assertTrue($view['items']->contains($item3)); //Should contain all 3 inserted items
		$this->assertFalse($view['items']->contains($item4)); //Should not contain this non-inserted item
	}
}
