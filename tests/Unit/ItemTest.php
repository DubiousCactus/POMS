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

		$item = factory(Item::class)->make();

		$response = $this->actingAs($adminUser)
						->json('PUT', '/manage/items', [
							'name' => $item->name,
							'ingredients' => $item->ingredients,
							'price' => $item->price
						]);

		$response->assertStatus(200)
				->assertJsonStructure([
					'name',
					'ingredients',
					'price',
					'updated_at',
					'created_at',
					'id'
				]);
	   	
    	$this->assertDatabaseHas('items', [
	        'name' => $item->name,
    		'ingredients' => $item->ingredients,
    		'price' => $item->price 
	    ]);
	}
}
