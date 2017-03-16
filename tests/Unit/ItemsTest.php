<?php

namespace Tests\Unit;

use App\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemsTest extends TestCase
{
	use DatabaseMigrations;
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateItem()
    {
    	$item = Item::create([
    		'name' => 'Pizza royale',
    		'ingredients' => 'Pepperoni, cheese, tomato, oregano',
    		'price' => 75
    	]);

    	$this->assertDatabaseHas('items', [
	        'name' => 'Pizza royale',
    		'ingredients' => 'Pepperoni, cheese, tomato, oregano',
    		'price' => 75
	    ]);
	}
}
