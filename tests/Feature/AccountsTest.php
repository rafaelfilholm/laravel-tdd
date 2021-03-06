<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Test api view one account
     */
    public function testApiViewOneAccount()
    {
        /**
         * Create one account
         */
        $data = factory(\App\Account::class)->create();

        /**
         * Makes a GET request to /api/accounts/{id}
         */
        $response = $this->json('GET', '/api/accounts/' . $data->id);

        /**
         * Checks if HTTP status code of request is 200
         * and if response has a JSON as $data
         */
        $response->assertStatus(200)
            ->assertJson($data->toArray());
    }

    /**
     * Test API view one account that is not in database
     */
    public function testApiViewOneAccountThatIsNotInDatabase()
    {

        /**
         * Makes a GET request to /api/accounts/{id}
         */
        $response = $this->json('GET', '/api/accounts/1');

        /**
         * Checks if HTTP status code of request is 404
         */
        $response->assertStatus(404);
    }

    /**
     * Test api endpoint of insert an account
     */
    public function testApiInsertAccount()
    {
        /**
         * Make a object base in model Account
         */
        $data = factory(\App\Account::class)->make();

        /**
         * Makes a POST request to /api/accounts passing $data
         */
        $response = $this->json('POST', '/api/accounts', $data->toArray());

        /**
         * Checks if HTTP status code of request is 200
         * and if response has a JSON as $data
         */
        $response->assertStatus(200)
            ->assertJson($data->toArray());
    }

    /**
     * Test api update an account
     */
    public function testApiUpdateAccount()
    {
        /**
         * Create one account
         */
        $data = factory(\App\Account::class)->create();

        $toUpdate = ['title' => 'Conta do Rafael'];


        /**
         * Makes a PUT request to /api/accounts/{id} passing data to update
         */
        $response = $this->json('PUT', '/api/accounts/' . $data->id, $toUpdate);

        /**
         * Checks if HTTP status code of request is 200
         * and if response has a JSON as $data
         */
        $response->assertStatus(200)
            ->assertJson($toUpdate);
    }

    /**
     * Test api delete an account
     */
    public function testApiDeleteAccount()
    {
        /**
         * Create one account
         */
        $data = factory(\App\Account::class)->create();

        /**
         * Makes a DELETE request to /api/accounts/{id}
         */
        $response = $this->json('DELETE', '/api/accounts/' . $data->id);

        /**
         * Checks if HTTP status code of request is 200
         */
        $response->assertStatus(200)
            ->assertJson($data->toArray());

    }

    /**
     * Test of upload image on insert a account
     */
    public function testApiUploadOnInsert()
    {
        /**
         * Make a object base in model Account
         */
        $data = factory(\App\Account::class)->make();
        $data = $data->toArray();

        /**
         * Create a fake public storage
         */
        Storage::fake('public');

        /**
         * Set a fake image in $data
         */
        $data['bank_image'] = UploadedFile::fake()->image('bank_name.jpg', 200, 200);

        /**
         * Makes a POST request to /api/accounts passing $data
         */
        $response = $this->json('POST', '/api/accounts', $data);

        /**
         * Checks if has this image in disk storage
         */
        Storage::disk('public')->assertExists('images/bank_name.jpg');
    }

}
