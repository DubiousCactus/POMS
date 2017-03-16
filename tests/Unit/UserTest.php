<?php

namespace Tests\Unit;

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

		$user = factory(User::class)->create();

		$this->assertDatabaseHas('users', [
			'name' => $user->name,
			'email' => $user->email,
			'phone_number' => $user->phone_number,
			'password' => $user->password,
			'remember_token' => $user->remember_token
		]);
    }
}
