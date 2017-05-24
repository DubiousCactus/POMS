<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'phone_number' => '+' . $faker->randomNumber(5) . $faker->randomNumber(5),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function(Faker\Generator $faker) {

	return [
		'name' => $faker->word()
	];
});

$factory->define(App\Item::class, function (Faker\Generator $faker) {

	return [
		'name' => $faker->sentence(3, true),
		'ingredients' => $faker->sentence(8, true),
		'price' => $faker->randomFloat(2, 55, 130)
	];
});

$factory->define(App\Topping::class, function (Faker\Generator $faker) {

	return [
		'name' => $faker->word(),
		'price' => $faker->randomFloat(2, 5, 20)
	];
});

$factory->define(App\Size::class, function (Faker\Generator $faker) {

	return [
		'name' => $faker->word(),
		'price' => $faker->randomFloat(2, 5, 20)
	];
});
