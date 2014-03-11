<?php
namespace Notejam\NoteBundle\Tests\Controller;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Notejam\UserBundle\Entity\User;

class UserControllerTest extends WebTestCase
{
    public function setUp() 
    {
        $this->loadFixtures(array());
        // init kernel to init entity manager
        static::$kernel = static::createKernel(array('environment' => 'test'));
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager() ;
        
    }

    private function _createUser($email, $password) {
        $user = new User();
        $user->setEmail($email)
             ->setPassword($password);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
    
    private function _signIn($username, $password)
    {
        $client = static::createClient();
        $session = $this->client->getContainer()->get('session');

        $firewall = 'main';
        $token = new UsernamePasswordToken(
            $username, $password, $firewall, array('ROLE_USER')
        );
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
        return $client;
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
        $user = $this->_createUser($email, '123123');

        $client = static::createClient();
        $crawler = $client->request('GET', '/signup');
        $form = $crawler->filter('button')->form();
        $form['user[email]'] = $email;
        $form['user[password][password]'] = 'password';
        $form['user[password][confirm]'] = 'password';
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('ul.errorlist > li')->count());
        $this->assertEquals(
            'Email already taken', 
            $crawler->filter('ul.errorlist > li')->text()
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
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/signin');
        $form = $crawler->filter('button')->form();
        $form['form[email]'] = 'test@example.com';
        $form['form[password]'] = 'password1';
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('div.alert-error')->count());
    }

    public function testSigninErrorRequiredFields() 
    {
    }
}
