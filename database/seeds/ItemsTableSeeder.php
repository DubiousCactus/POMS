<?php

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

        for ($i = 0; $i < 15; $i++) { //Create 15 dummy pizzas/items in the database
        	DB::table('items')->insert([
        		'name' => $faker->sentence(3, true),
        		'ingredients' => $faker->sentence(8, true),
        		'price' => $faker->randomFloat(2, 55, 130) //2 decimals, min = 55, max = 130
        	]);
        }
    }
}
