<?php

class UserTest extends TestCase {

    public function getUserData() {
        return array(
            'email' => 'user@example.com',
            'password' => 'secure_password'
        );
    }

    public function testSignupSuccess()
    {
        $data = $this->getUserData();
        $data['password_confirmation'] = $data['password'];
        $data['_token'] = csrf_token();
        $crawler = $this->client->request(
            'POST', URL::route('signup'), $data
        );
        $this->assertRedirectedToRoute('signin');
        $this->assertEquals(1, User::all()->count());
    }

    public function testSignupFailRequiredFields()
    {
        // code...
    }

    public function testSignupFailInvalidEmail()
    {
        // code...
    }

    public function testSignupFailEmailExists()
    {
        // code...
    }

    public function testSignupFailPasswordsNotMatch()
    {
        // code...
    }
}

