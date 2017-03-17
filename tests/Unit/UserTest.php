<?php

namespace Tests\Unit;

use Faker\Factory;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
	use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegisterUser()
	{
		$response = $this->get('/register');
		$response->assertStatus(200); //Make sure the link works

		$faker = Factory::create();

		$user = factory(User::class)->make([
			'password' => $faker->password() //Don't hash it cause we use the model to POST it
		]);
		
		$response = $this->json('POST', '/register', [
			'name' => $user->name,
			'email' => $user->email,
			'phone_number' => $user->phone_number,
			'password' => $user->password,
			'password-confirmation' => $user->password
		]);

		$response->assertStatus(200);

		$this->assertDatabaseHas('users', [
			'name' => $user->name,
			'email' => $user->email,
			'phone_number' => $user->phone_number
		]);
    }
}
