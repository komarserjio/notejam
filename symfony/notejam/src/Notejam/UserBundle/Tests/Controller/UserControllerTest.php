<?php

namespace Notejam\NoteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testSignupSuccess() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signup');
        $form = $crawler->filter('button')->form();
        $form['user[email]'] = 'test@example.com';
        $form['user[password][password]'] = 'test@example.com';
        $form['user[password][confirm]'] = 'test@example.com';
        $crawler = $client->submit($form);
    }

    public function testSignupFailInvalidEmail() 
    {
    }

    public function testSignupFailEmailAlreadyExists() 
    {
    }

    public function testSignupFailPasswordsDoNotMatch() 
    {
    }

    public function testSignupFailRequiredFields() 
    {
    }

    public function testSigninSuccess() 
    {
    }

    public function testSigninFail() 
    {
    }

    public function testSigninErrorRequiredFields() 
    {
    }
}

