<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountsTest extends TestCase
{
	use DatabaseMigrations;

    /**
     * Test api list accounts
     */
    public function testApiListAccounts()
    {
    	/**
    	 * Create 20 accounts
    	 */
    	$data = factory(\App\Account::class, 20)->create();
        
        /**
         * Get response of endpoint /api/accounts
         */

        $response = $this->get('/api/accounts');
        /**
         * Checks if HTTP status code of request is 200
         * and if has $data of accounts
         */
        $response->assertStatus(200)
        	->assertJson(['data' => $data->toArray()]);
    }
}
