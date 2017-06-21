<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Factory::create();

		for ($i = 0; $i < 4; $i++) //Create 4 dummy categories
			factory(App\Category::class)->create();

		App\Category::first()->update(['has_toppings' => true]);
    }
}
