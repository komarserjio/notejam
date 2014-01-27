<?php
namespace Notejam\NoteBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Notejam\UserBundle\Entity\User;

class UserControllerTest extends WebTestCase
{
    public function setUp() {
        $this->loadFixtures(array());
        static::$kernel = static::createKernel(array('environment' => 'test'));
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager() ;
        
    }

    public function testSignupSuccess() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signup');
        $form = $crawler->filter('button')->form();
        $form['user[email]'] = 'test@example.com';
        $form['user[password][password]'] = 'test@example.com';
        $form['user[password][confirm]'] = 'test@example.com';
        $crawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertCount(
            1, $this->em->getRepository('NotejamUserBundle:User')->findAll()
        );
    }

    public function testSignupFailInvalidEmail() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signup');
        $form = $crawler->filter('button')->form();
        $form['user[email]'] = 'invalid email';
        $form['user[password][password]'] = 'password';
        $form['user[password][confirm]'] = 'password';
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('ul.errorlist > li')->count());
        $this->assertEquals(
            'Email is invalid', $crawler->filter('ul.errorlist > li')->text()
        );
    }

    public function testSignupFailEmailAlreadyExists() 
    {
        $email = 'test@example.com';
        $user = new User();
        $user->setEmail($email)
             ->setPassword('123123');
        $this->em->persist($user);
        $this->em->flush();

        $client = static::createClient();
        $crawler = $client->request('GET', '/signup');
        $form = $crawler->filter('button')->form();
        $form['user[email]'] = $email;
        $form['user[password][password]'] = 'password';
        $form['user[password][confirm]'] = 'password';
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('ul.errorlist > li')->count());
        $this->assertEquals(
            'Email already taken', $crawler->filter('ul.errorlist > li')->text()
        );
    }

    public function testSignupFailPasswordsDoNotMatch() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signup');
        $form = $crawler->filter('button')->form();
        $form['user[email]'] = 'test@example.com';
        $form['user[password][password]'] = 'password1';
        $form['user[password][confirm]'] = 'password2';
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('ul.errorlist > li')->count());
        $this->assertEquals(
            'The password fields do not match.', 
            $crawler->filter('ul.errorlist > li')->text()
        );
    }

    public function testSignupFailRequiredFields() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signup');
        $form = $crawler->filter('button')->form();
        $crawler = $client->submit($form);
        $this->assertEquals(3, $crawler->filter('ul.errorlist > li')->count());
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
