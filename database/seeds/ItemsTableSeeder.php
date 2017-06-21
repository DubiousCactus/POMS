<?php

use App\Category;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

		foreach (Category::all() as $category) {
			for ($i = 0; $i < 4; $i++) { //Create 4 dummy pizzas/items in the database
				$item = factory(App\Item::class)->make();
				$category->items()->save($item);
			}
		}
    }
}
