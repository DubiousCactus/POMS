<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$this->call(CategoriesTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
		$this->call(ToppingsTableSeeder::class);
		$this->call(SizesTableSeeder::class);
    }
}
