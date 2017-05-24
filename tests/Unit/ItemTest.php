<?php

namespace Tests\Unit;

use Auth;
use App\Item;
use App\User;
use App\Category;
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

		/* Dummy category */
		$category = factory(Category::class)->create();

		/* Test: adminUser must get access */
		$response = $this->actingAs($adminUser)->get('/manage/items/add');
		$response->assertStatus(200);
		$response->assertSessionMissing('error');


		/* Test: user must not get access */
		$response = $this->actingAs($user)->get('/manage/items/add');
		$response->assertSessionHas('error');

		$adminItem = factory(Item::class)->make();
		
		/* Create item as administrator */
		$response = $this->actingAs($adminUser)
			->json('POST', route('item.store'), [
				'name' => $adminItem->name,
				'ingredients' => $adminItem->ingredients,
				'price' => $adminItem->price,
				'category_id' => $category->id
			]);
		$response->assertStatus(302); //Created successfuly, redirected
		$response->assertSessionMissing('error');

		/* Create item as basic user */
		$item = factory(Item::class)->make();

		$response = $this->actingAs($user)
			->json('POST', route('item.store'), [
				'name' => $item->name,
				'ingredients' => $item->ingredients,
				'price' => $item->price,
				'category' => $category->id
		]);

		$response->assertSessionHas('error'); //Forbidden

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
		$item1 = factory(Item::class)->make();
		$item2 = factory(Item::class)->make();
		$item3 = factory(Item::class)->make();

		$category = factory(Category::class)->create();
		$category->items()->saveMany([$item1, $item2, $item3]);

		$item4 = factory(Item::class)->make(); //Don't insert this one

		/* A guest should be able to consult the menu */
		$response = $this->get('/');
		$view = $response->original; //Get the view from the landing page

		$this->assertTrue($view['items']->contains($item1));
		$this->assertTrue($view['items']->contains($item2));
		$this->assertTrue($view['items']->contains($item3)); //Should contain all 3 inserted items
		$this->assertFalse($view['items']->contains($item4)); //Should not contain this non-inserted item
	}

	/*
	 * Item deletion test.
	 */
	public function testDeleteItem()
	{
		/* Create dummy item to be deleted */
		$item = factory(Item::class)->make();
		$category = factory(Category::class)->create();
		$category->items()->save($item);

		/* Create basic user */
		$user = factory(User::class)->create();

		/* Create admin user */
		$adminUser = factory(User::class)->make();
		$adminUser->is_admin = true;
		$adminUser->save();

		/* Basic user shouldn't get access to the admin panel */
		$response = $this->actingAs($user)->get('/manage/items');
		$response->assertSessionHas('error'); //Forbidden

		/* Admin user should get access to the admin panel */
		$response = $this->actingAs($adminUser)->get('/manage/items');
		$response->assertStatus(200); //Okay

		/* Basic user shouldn't be able to delete the item */
		$response = $this->actingAs($user)->json('DELETE', route('item.destroy', ['item' => $item]), []);
		$response->assertSessionHas('error'); //Forbidden

		/* Admin user should be able to delete the item */
		$response = $this->actingAs($adminUser)->json('DELETE', route('item.destroy', ['item' => $item]), []);
		$response->assertStatus(302); //Redirected but okay
		$response->assertSessionMissing('error');

		/* Make sure it has been deleted from the database */
		$this->assertDatabaseMissing('items', [
			'name' => $item->name,
			'ingredients' => $item->ingredients,
			'price' => $item->price
		]);
	}

	/*
	 * Item modification test.
	 */
	public function testUpdateItem()
	{
		/* Create dummy item to be deleted */
		$item = factory(Item::class)->make();
		$category = factory(Category::class)->create();
		$category->items()->save($item);

		/* Create basic user */
		$user = factory(User::class)->create();

		/* Create admin user */
		$adminUser = factory(User::class)->make();
		$adminUser->is_admin = true;
		$adminUser->save();

		/* Basic user shouldn't get access to the admin panel */
		$response = $this->actingAs($user)->get('/manage/items/' . $item->id . '/edit');
		$response->assertSessionHas('error'); //Forbidden

		/* Admin user should get access to the admin panel */
		$response = $this->actingAs($adminUser)->get('/manage/items/' . $item->id . '/edit');
		$response->assertStatus(200); //Okay

		/* Basic user shouldn't be able to delete the item */
		$response = $this->actingAs($user)
			->json('PATCH', route('item.update', ['item' => $item]), [
				'name' => 'Another name',
				'ingredients' => 'Another ingredients list',
				'price' => 0	
			]);
		$response->assertSessionHas('error'); //Forbidden

		/* Admin user should be able to delete the item */
		$response = $this->actingAs($adminUser)
			->json('PATCH', route('item.update', ['item' => $item]), [
				'name' => 'Another different name',
				'ingredients' => 'Another different ingredients list',
				'price' => 0.5
			]);
		$response->assertStatus(302); //Redirected but okay
		$response->assertSessionMissing('error');

		/* Make sure the previous values are missing from the database */
		$this->assertDatabaseMissing('items', [
			'name' => $item->name,
			'ingredients' => $item->ingredients,
			'price' => $item->price
		]);

		/* Make sure the basic user's modifications are missing from the database */
		$this->assertDatabaseMissing('items', [
			'name' => 'Another name',
			'ingredients' => 'Another ingredients list',
			'price' => 0
		]);

		/* Make sure the admin user's modifications are present in the database */
		$this->assertDatabaseHas('items', [
			'name' => 'Another different name',
			'ingredients' => 'Another different ingredients list',
			'price' => 0.5
		]);
	}
}
