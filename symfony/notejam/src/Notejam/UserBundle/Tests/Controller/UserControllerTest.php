<?php
namespace Notejam\NoteBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;


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
        $form['user[email]'] = 'test1@example.com';
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
    }

    public function testSignupFailEmailAlreadyExists() 
    {
    }

    public function testSignupFailPasswordsDoNotMatch() 
    {
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
