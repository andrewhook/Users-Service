<?php

use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
    /**
     * Clean up when test is finished.
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

    /**
     * Test we can create a new user.
     * 
     * @return void
     */
    public function test_it_creates_a_new_user()
    {
        $user = ['email' => 'me@andrewhook.uk', 'given_name' => 'Andrew', 'family_name' => 'Hook'];

        $this->json('POST', '/users', $user)
             ->seeJson($user);
    }

    /**
     * Ensure a new user isn't created if validation fails.
     * 
     * @return void
     */
    public function test_it_does_not_create_a_new_user_if_validation_fails()
    {
        $user = ['given_name' => 'Andrew', 'family_name' => 'Hook'];

        $response = $this->call('POST', '/users', $user);

        $this->assertEquals(422, $response->status());
        $this->assertEquals(json_encode(['email' => ['The email field is required.']]), $response->getContent());
    }

    /**
     * Test we can get a single user.
     *
     * @return void
     */
    public function test_it_returns_a_single_user()
    {
        $user = User::insert(['email' => 'me@andrewhook.uk', 'given_name' => 'Andrew', 'family_name' => 'Hook']);

        $response = $this->call('GET', '/users/1');

        $this->assertEquals(200, $response->status());
        $this->assertEquals($user->toJson(), $response->getContent());
    }
}
