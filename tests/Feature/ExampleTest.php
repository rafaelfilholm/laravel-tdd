<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testDatabaseUsers()
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
