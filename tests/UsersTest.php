<?php

use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
    /**
     * Clean up when tests are finished.
     * 
     * @return void
     */
    public function tearDown()
    {
        User::truncate();
    }

    /**
     * Test we can get a listing of all users.
     *
     * @return void
     */
    public function test_it_returns_a_list_of_users()
    {
        User::insert([
            ['email' => 'me@andrewhook.uk', 'given_name' => 'Andrew', 'family_name' => 'Hook'],
            ['email' => 'andy@andrewhook.uk', 'given_name' => 'Andy', 'family_name' => 'Hook'],
        ]);

        $response = $this->call('GET', '/users');

        $this->assertEquals(200, $response->status());
        $this->assertEquals(User::all()->toJson(), $response->getContent());
    }
}
