<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testAuthentication()
    {
        /**
         * Create a new user
         */
        $user = factory(\App\User::class)->create();

        /**
         * Try to access a guarded route with user data
         */
        $response = $this->actingAs($user)->get('/home');

        /**
         * Check if http code status is 200
         */
        $response->assertStatus(200);

    }

    public function testInsertOfOneUser()
    {
        /* Create a user */
        factory(\App\User::class)->create([
            'email' => 'teste@teste.com'
        ]);

        /* Check if user exists */
        $this->assertDatabaseHas('users', [
            'email' => 'teste@teste.com'
        ]);
    }

}
