<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	use DatabaseTransactions;

    /**
	 * User registration test.
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
	
	/**
	 * User login test.	
     *
     * @return void
     */
    public function testLoginUser()
	{
		$response = $this->get('/login');
		$response->assertStatus(200); //Make sure the link works

		/* First we register a user */
		$user = factory(User::class)->create();

		/* Then we make sure we can log him in */
		$response = $this->actingAs($user)->get('/');
		$response->assertStatus(200);
    }

}