<?php

class UserTest extends TestCase {

    public function getUserData($override = array()) {
        return array_merge(
            array(
                'email' => 'user@example.com',
                'password' => 'secure_password'
            ),
            $override
        );
    }

    public function testSignupSuccess()
    {
        $data = $this->getUserData();
        $data['password_confirmation'] = $data['password'];
        $crawler = $this->client->request(
            'POST', URL::route('signup'), $data
        );
        $this->assertRedirectedToRoute('signin');
        $this->assertEquals(1, User::all()->count());
    }

    public function testSignupFailRequiredFields()
    {
        $crawler = $this->client->request(
            'POST', URL::route('signup'), array()
        );
        $this->assertSessionHasErrors(
            array('email', 'password', 'password_confirmation')
        );
    }

    public function testSignupFailInvalidEmail()
    {
        $data = $this->getUserData(array('email' => 'invalid'));
        $crawler = $this->client->request(
            'POST', URL::route('signup'), $data
        );
        $this->assertSessionHasErrors('email');
    }

    public function testSignupFailEmailExists()
    {
        $email = 'exists@example.com';
        $user = User::create(
            array('email' => $email, 'password' => 'password')
        );

        $data = $this->getUserData(array('email' => $email));
        $crawler = $this->client->request(
            'POST', URL::route('signup'), $data
        );
        $this->assertSessionHasErrors('email');
    }

    public function testSignupFailPasswordsNotMatch()
    {
        $data = $this->getUserData();
        $data['password_confirmation'] = 'another_password';
        $crawler = $this->client->request(
            'POST', URL::route('signup'), $data
        );
        $this->assertSessionHasErrors('password');
    }
}

