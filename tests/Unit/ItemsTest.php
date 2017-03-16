<?php

namespace Tests\Unit;

use App\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemsTest extends TestCase
{
	use DatabaseTransactions;
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateItem()
	{
		$item = factory(Item::class)->create();

    	$this->assertDatabaseHas('items', [
	        'name' => $item->name,
    		'ingredients' => $item->ingredients,
    		'price' => $item->price
	    ]);
	}
}
