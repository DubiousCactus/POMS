<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class ToppingsTableSeeder extends Seeder
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
        	DB::table('toppings')->insert([
        		'name' => $faker->sentence(1, false),
        		'price' => $faker->randomFloat(2, 55, 130) //2 decimals, min = 55, max = 130
        	]);
        }
    }
}
